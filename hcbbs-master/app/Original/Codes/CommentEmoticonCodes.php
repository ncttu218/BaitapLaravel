<?php

namespace App\Original\Codes;

/**
 * 表示/非表示を表すコード
 *
 * @author yhatsutori
 *
 */
class CommentEmoticonCodes extends Code {
    
    /**
     * 絵文字無し
     * 
     * 高崎
     */
    const COMMENT_EMOTICON_NONE= -1;
    
    /**
     * デフォルトスタイル
     * 
     * 東京中央様
     */
    const COMMENT_EMOTICON_DEFAULT = 0;
    
    /**
     * スタイル１
     * 
     * 北海道様
     */
    const COMMENT_EMOTICON_STYLE1 = 1;
    
    /**
     * スタイル2
     * 
     * 北海道様
     */
    const COMMENT_EMOTICON_STYLE2 = 2;
    
    /**
     * スタイル3
     * 
     * 北海道様
     */
    const COMMENT_EMOTICON_STYLE3 = 3;
    
    /**
     * コード
     * 
     * @var array
     */
    private $codes = [
        
        self::COMMENT_EMOTICON_NONE => [
        ],
        
        self::COMMENT_EMOTICON_DEFAULT => [
            '001' => '面白かった',
            '002' => '驚いた',
            '003' => '楽しかった',
            '004' => 'おいしそう',
            '005' => '悲しかった',
            '006' => '悔しい',
            '007' => 'キレイだった',
            '008' => '感動した',
            '009' => 'かわいかった',
            '010' => '怒った',
            '011' => 'ワクワクした',
            '012' => '怖かった',
        ],
        
        self::COMMENT_EMOTICON_STYLE1 => [
            '001' => '面白かった',
            '002' => '驚いた',
            '003' => '楽しかった',
            '004' => 'おいしそう',
            '007' => 'キレイだった',
            '008' => '感動した',
            '009' => 'かわいかった',
            '011' => 'ワクワクした',
        ],
        
        self::COMMENT_EMOTICON_STYLE2 => [
            '001' => '面白かった',
            '002' => '驚いた',
            '003' => '楽しかった',
            '004' => 'おいしそう',
            '006' => '悔しい',
            '007' => 'キレイだった',
            '008' => '感動した',
            '009' => 'かわいかった',
            '011' => 'ワクワクした',
        ],
        
        self::COMMENT_EMOTICON_STYLE3 => [
            '001' => '面白かった',
            '002' => '役に立った',
            '003' => '楽しそう',
            '004' => '美味しそう',
            '007' => 'キレイ！',
            '008' => '感動した',
            '009' => 'かわいい',
            '011' => 'ワクワクした',
        ]
    ];

    /**
     * コンストラクタ
     */
    public function __construct( $key = self::COMMENT_EMOTICON_DEFAULT ) {
        parent::__construct( $this->codes[$key] );
    }
}
