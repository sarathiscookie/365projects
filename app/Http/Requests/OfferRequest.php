<?php

namespace App\Http\Requests;

use App\Formfield;
use App\Http\Requests\Request;

class OfferRequest extends Request
{
    public $formFields;
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
        $rules = [
            'title' => 'required'
        ];
        //if validation set for dynamic form_fields
        $j = 0;
        while($j < count($this->request->get('fieldID'))) {
            $id = $this->request->get('fieldID')[$j];
            $form_field = Formfield::where('id',$id)->select('title','validation')->first();
            if($form_field->validation!=null && $form_field->validation!='')
            {
                $rules['dynField_'.$id] = $form_field->validation;
                $this->formFields['dynField_'.$id]= $form_field->title;
            }
            $j++;
        }
        return $rules;
    }

    /**
     * Set Field Alias names to error messages
     * @return array
     */
    public function attributes(){
        $label =[];
        if(count($this->formFields)>0)
        {
            foreach($this->formFields as $field =>$alias)
            {
                $label[$field] = $alias;
            }
        }
        return $label;
    }
}
