<?php 

namespace App\HTML;

class Form
{

    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label):string
    {
        $value = $this->getValue($key);
        $inputClass = 'form-control';
        $invalidFeedBack= null;
        if(!empty($this->errors[$key]))
        {
            $inputClass .= ' is-invalid';
            $invalidFeedBack = '<div class="invalid-feedback">' . implode('</br>', $this->errors[$key]) . '</div>';
        }

        return <<<HTML
        <div class="form-group">
        <label for="field{$key}">$label</label>
        <input class="{$this->getInputClass($key)}" id="field{$key}" type="text" name="{$key}" value="{$value}">
        {$this->getErrorFeedBack($key)}
HTML;        
    }

    public function textarea(string $key, string $label):string
    {
        $value = $this->getValue($key);


        return <<<HTML
        <div class="form-group">
        <label for="field{$key}">$label</label>
        <textarea class="{$this->getInputClass($key)}" id="field{$key}" type="text" name="{$key}"> {$value} </textarea>
        {$this->getErrorFeedBack($key)}
HTML;  
    }

    private function getValue(string $key): ?string
    {
        if(is_array($this->data))
        {
            return $this->data[$key] ?? null;
        }
        $methode = 'get'. str_replace(' ', '', ucwords(str_replace('_',' ', $key)));
        $value = $this->data->$methode();
        if($value instanceOf \DateTime){

           return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if(!empty($this->errors[$key]))
        {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorFeedBack(string $key): ?string
    {
        $invalidFeedBack= null;
        if(!empty($this->errors[$key]))
        {
            $invalidFeedBack = '<div class="invalid-feedback">' . implode('</br>', $this->errors[$key]) . '</div>';
        }
        return $invalidFeedBack;
    }

    
}