<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{
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
        switch ($this->method()) {
    		case 'GET':
    		case 'DELETE':
    		return [];
    		case 'POST': {
    			return [
    				'producto_id'   => 'required',
                    'talla_id'      => 'required',
                    'color_id'      => 'required',
    				'cantidad'         => 'required',
    			];
    		}
    		case 'PUT': {
    			return [
    				'producto_id'   => 'required',
                    'talla_id'      => 'required',
                    'color_id'      => 'required',
    				'cantidad'         => 'required',
    			];
    		}
    	}
    }
}
