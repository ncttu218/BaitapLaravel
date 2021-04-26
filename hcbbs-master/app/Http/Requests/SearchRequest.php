<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'row_num' => '',
        ];
    }

    /**
     * [getInstance description]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public static function getInstance( $array=null ) {
        $request = static::setCommonCondition();

        if( !empty( $array ) ) {
            foreach ( $array as $key => $value ) {
                $request->{$key} = $value;
            }
        }
        
        return $request;
    }

    /**
     * [setCommonCondition description]
     */
    private static function setCommonCondition() {

        $request = new SearchRequest();
        $request->row_num = 20;

        return $request;
    }
    
}
