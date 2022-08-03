<?php

namespace Apps\Shared\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{

    private ?FormRequestHelper $helper = null;

    /**
     * Singleton
     * @return FormRequestHelper
     */
    protected function getHelper(): FormRequestHelper
    {
        if ($this->helper === null) {
            $this->helper = new FormRequestHelper($this);
        }
        return $this->helper;
    }

    public function wantJson()
    {
        $helper = $this->getHelper();
        $helper->expectJson();
    }

    /**
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
