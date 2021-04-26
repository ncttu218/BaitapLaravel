{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- メイン部分の呼び出し --}}
@section('content')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">利用規約</h2>

    <section class="p-rule">
        <h3 class="p-rule__head">情報掲載上の注意点</h3>
        <div class="p-rule__body">

            <p class="p-rule-text">情報掲載時には、販社HP運用ガイドライン <a href="http://info.honda.co.jp/koukai/" target="_blank">http://info.honda.co.jp/koukai/</a>（ID:manual／Pass:guest）の内容に沿って、記事内に問題点の無いことを必ずご確認ください。</p>

            <article class="p-rule-checkpoint">
                <h4 class="p-rule-checkpoint__head">セルフチェック項目</h4>
                <ol class="p-rule-checkpoint__list">
                    <li>新車規約、中古車規約、景品規約、消費税総額表示、リサイクル法、古物営業法などの各種法令を遵守しています。コンプライアンス違反はありません。</li>
                    <li>正しい情報を遅滞なく掲載しています。新車ラインナップ、中古車情報、拠点情報などに現状との相違はありません。</li>
                    <li>掲載期間の定められた情報（新車上市、キャンペーンなど）について情報の先出しや無効となった情報の掲載はありません。</li>
                    <li>個人情報漏洩や、著作権違反、肖像権違反など、他者の権利侵害となる情報掲載はありません。</li>
                    <li>正しいHondaブランド表現を行っています。（VIの使い方、テキスト表記方法など）</li>
                </ol>
            </article>

            <article class="p-rule-important">
                <h4 class="p-rule-important__head">新型車の情報を<br>事前に掲載することは厳禁です</h4>
                <ul class="p-rule-important__list">
                    <li>発表日前日までは規定のティザーアドフォーマットのみ掲載可能ですが、<em>アドフォーマットの改変やアドフォーマット以外の画像や文章による告知は禁止されています。</em></li>
                    <li>掲載された場合には、<em>順次削除処理されます</em>ので、ご注意下さいますようお願いいたします。</li>
                    <li>内覧会・内見会のご案内対象は、販売会社様の特別なお客様に限定されています。<br>ホームページのような不特定多数のお客様がご覧になるような場所でのご発信はお控えください。</li>
                </ul>
            </article>

        </div>
    </section>
    <!-- / .p-rule -->

    <section class="p-rule">
        <h3 class="p-rule__head">画像掲載時の注意点</h3>
        <div class="p-rule__body">
            <p class="p-rule-text">以下を許可なく掲載し、著作権問題に至った事例が発生しています。十分にご注意ください。</p>
            <ul class="p-rule-list">
                <li>著名人の画像(芸能人やプロスポーツ選手･監督など）</li>
                <li>本人の承諾の無いお客様の画像・写真</li>
                <li>他サイトの画像やイラストの使用はお控えください（有料の場合がございます）</li>
                <li>その他市販の著作物（書籍･DVD･CDなど）</li>
                <li>歌詞の引用はお控えください。<br>引用について<a href="#">詳しくはこちら</a>からご確認ください。</li>
            </ul>
            <p class="p-rule-text"><em>※著名人の画像を掲載すると肖像権や財産権を侵害する恐れがあります。画像は必ずオリジナルで作成・撮影したものを使用し、自分以外の人物を掲載する場合は必ず本人の承諾を得てください。</em></p>
        </div>
    </section>
    <!-- / .p-rule -->

    <section class="p-rule">
        <h3 class="p-rule__head">例外なくNGな文言(コンプライアンス)</h3>
        <div class="p-rule__body">
            <p class="p-rule-text">コンプライアンスの観点から以下の文言の使用は例外なくNGとなっております。</p>
            <p class="p-rule-words">新古車 / ナンバー付新車 / 卸し値 / 未走行車 / 新車同様な中古車 / ナンバー付き新車 / 仕入れ価格 / 掘り出し価格 / 旧型新車 / 準新車 / 卸し価格 / 新粧車 / 仕入れ値 / 卸値 / 掘り出し値 / 新車同様の中古車 / 掘出し値 / 掘出し価格 / 限りなく新車に </p>
            <p class="p-rule-text">これらの文言が使用されておりますとデータを登録できませんのでご注意ください。</p>
        </div>
    </section>
    <!-- / .p-rule -->

    <section class="p-rule">
        <h3 class="p-rule__head">掲載内容のチェックについて</h3>
        <div class="p-rule__body">
            <p class="p-rule-text">入力いただいた内容については「Honda Cars ホームページ事務局(以下HP事務局)」で随時チェックを行っております。<br>
            内容に問題があった場合には、HP事務局にて該当記事を非公開とさせていただくとともにHP事務局もしくは担当営業より内容の修正をお願いする場合がございますので、その際は修正のご対応をいただけますようお願い申し上げます。</p>
            <p class="p-rule-text">記事の再公開は修正対応をいただいた後にHP事務局側で再チェックを行い、問題の無いことを確認した後の処理となります。<br>
                <em>※再公開処理はHP事務局の稼動時間内（平日10:00～18:00）の対応となりますのでご注意下さい。</em></p>
            <p class="p-rule-text">「非公開」や「掲載期間外」でないにもかかわらず、「一度入力して公開された記事が公開画面から消えた」という場合には上記処理の対象となっている場合があります。</p>
        </div>
    </section>
    <!-- / .p-rule -->
</section>
@stop
                        