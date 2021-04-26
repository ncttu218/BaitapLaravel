<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of IDynamicTableName
 *
 * @author ohishi
 */
interface IDynamicTableName {
    
    /**
     * テーブル名を変更する時の対応
     * 
     * @param string $name
     */
    public function onTableNameChanging( $name );
}
