#!/usr/bin/perl

#起動フラグ
use Net::POP3;
use Net::SMTP;
use Email::MIME;
use Email::MIME::ContentType;
use Email::MIME::XPath;
use MIME::Base64;
use File::Path;
#use JSON;
#use Cwd qw(cwd);

# デバッグ
use warnings;
use strict;
use IO::Handle;

require MIME::Base64;

# UTF-8に対応
binmode STDOUT, ":utf8";
use utf8;

# 時間帯
use POSIX qw(tzset);
$ENV{TZ} = 'Asia/Tokyo';
tzset;

# 現在フォルダー
#my $cwd = cwd;

# メールサーバとアカウントの設定
my $server   = 'mail.hondanet.co.jp';
#my $account  = 'aws-upload-test@hondanet.co.jp';
#my $password = 'v8#UbrRf';
my $account  = 'aws-upload2@hondanet.co.jp';
my $password = '*r2UujKw';
my $protocol = 'pop3';        # pop3/apop

my $cwd = "/home/web.hondanet.co.jp/vsites/laravel/hcbbs";

&main($server, $account, $password, $protocol);

# 主処理
sub main {
  my ($server, $account, $password, $protocol) = @_;

  # Net::POP3オブジェクトを生成し、ログイン
  my $pop3  = Net::POP3->new($server) or die "Can't connect to the server.";
  my $login = (lc($protocol) eq 'apop') ? 'apop' : 'login';
  $pop3->$login($account, $password) or die "Can't login.";

  # メールID/サイズのハッシュリファレンスを取得
  my $messages = $pop3->list();

  # 調整する必要がある → 情報掲示板のパス
  my $dir = "$cwd/storage/mailer/temp";

  # カウンター
  my $count = 0;
  my @mails = ();

  foreach my $i (sort (keys %{$messages})) {
    # メール読み込み
    my $mail  = join q(), @{ $pop3->get($i) };
    my ($id) = $mail =~ /[Mm]essage-[Ii][Dd]:\s<(.*?@.*?)>\n/;
    my $email = Email::MIME->new($mail);

    # メールファイルを保存
    if($id eq "") {
      $id = time();
    }
    push(@mails, $id);

    my $filename = "$dir/$id.eml";
    open(OUT, ">$filename");
    print OUT $mail;
    close(OUT);
    chmod 0777, $filename;

    my $to = $email->header('To');
    my $from = $email->header('From');
    my $subject = $email->header('Subject');
    my $sendDate = $email->header('Date');

    # サーバから削除
    $pop3->delete($i);

    # カウンター
    $count++;
  }

  # 接続を終了
  $pop3->quit;

  if ($count > 0) {
    my $datestring = localtime();
    my $filename = "$cwd/storage/logs/mailer.log";
    open(OUT, ">>$filename");
    print OUT "[$datestring] Received $count message(s)\n";
    foreach (@mails){
      print OUT "\t$_\n";
    }
    close(OUT);
    chmod 0777, $filename;
  }

  # リスポンスを表示
  print $count;
}