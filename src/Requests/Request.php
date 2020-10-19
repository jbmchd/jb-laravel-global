<?php

namespace JbGlobal\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    protected $metodo;
    protected $parametros;
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
        $this->metodo = $this->route()->getActionMethod();
        $this->parametros = $this->route()->parameters();
    }

    public function getMetodo()
    {
        return $this->metodo ?? $this->route()->getActionMethod();
    }

    public function getParametros()
    {
        return $this->parametros ??  $this->route()->parameters();
    }
}
