<?php 
namespace Modules\Core\Traits\Livewire;

trait WithValueMask {


    public function updated ($field, $value){
        if (property_exists($this, 'fieldsMask') && in_array($field, $this->fieldsMask)) {
            $this->$field = $this->formatValue($value);
        }
    }

    protected function formatValue($value){

        // Remove todos os caracteres que não são dígitos ou ponto
        $cleanedValue = preg_replace('/[^0-9.]/', '', $value);

        // Converte o valor para o formato desejado
        $formattedValue = number_format($cleanedValue, 2, '.', ',');

        return $formattedValue;
    }

    protected function clearValue($value){
        $cleanedValue = $value != '' ? preg_replace('/[^0-9.]/', '', $value) : 0;
        return $cleanedValue;
    }

}
