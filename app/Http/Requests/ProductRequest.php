<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                    'nombre'                => 'required|min:1|max:150',
                    'category_id'           => 'required',
                    'subcategory_id'        => 'required',
                    'tipo_id'               => 'required',
                    'descripcion_corta'     => 'required',
                    'descripcion_larga'     => 'required',
                    'marca'                 => 'required',
                    'color'                 => 'required',
                    'precioanterior'        => 'required',
                    'precioactual'          => 'required',
                    'porcentajededescuento' => 'sometimes',
                    'especificaciones'      => 'sometimes',
                    'datos_de_interes'      => 'sometimes',
                    'imagenes'              => 'required',
                    'activo'                => 'required',
                    'estado'                => 'sometimes',
                    'sliderprincipal'       => 'sometimes',

    			];
    		}
    		case 'PUT': {
    			return [
                    'nombre'                => 'required|min:1|max:150',
                    'category_id'           => 'required',
                    'subcategory_id'        => 'required',
                    'tipo_id'               => 'required',
                    'descripcion_corta'     => 'required',
                    'descripcion_larga'     => 'required',
                    'marca'                 => 'required',
                    'precioanterior'        => 'required',
                    'precioactual'          => 'required',
                    'porcentajededescuento' => 'sometimes',
                    'especificaciones'      => 'sometimes',
                    'datos_de_interes'      => 'sometimes',
                    'imagenes'              => 'sometimes',
                    'activo'                => 'sometimes',
                    'estado'                => 'sometimes',
                    'sliderprincipal'       => 'sometimes',    

    			];
    		}
    	}
    }
}
