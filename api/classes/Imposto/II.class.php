<?php
/**
 * MIT License
 *
 * Copyright (c) 2016 MZ Desenvolvimento de Sistemas LTDA
 *
 * @author Francimar Alves <mazinsw@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
namespace Imposto;

use Util;
use Imposto;
use Exception;
use DOMDocument;

/**
 * Funcionalidade para gerar as informações do II do item de produto da
 * NF-e. Este grupo só precisa ser informado em uma operação de importação
 * que tenha incidência de II.
 */
class II extends Imposto
{

    private $despesas;
    private $valor;
    private $iof;

    public function __construct($ii = array())
    {
        parent::__construct($ii);
        $this->setGrupo(self::GRUPO_II);
    }

    /**
     * Informar o valor das despesas aduaneiras
     */
    public function getDespesas($normalize = false)
    {
        if (!$normalize) {
            return $this->despesas;
        }
        return Util::toCurrency($this->despesas);
    }

    public function setDespesas($despesas)
    {
        $this->despesas = $despesas;
        return $this;
    }

    /**
     * Informar a o valor do Imposto de Importação
     */
    public function getValor($normalize = false)
    {
        if (!$normalize) {
            return $this->valor;
        }
        return Util::toCurrency($this->valor);
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Informar o Valor do IOF - Imposto sobre Operações Financeiras
     */
    public function getIOF($normalize = false)
    {
        if (!$normalize) {
            return $this->iof;
        }
        return $this->iof;
    }

    public function setIOF($iof)
    {
        $this->iof = $iof;
        return $this;
    }

    public function toArray()
    {
        $ii = parent::toArray();
        $ii['despesas'] = $this->getDespesas();
        $ii['valor'] = $this->getValor();
        $ii['iof'] = $this->getIOF();
        return $ii;
    }

    public function fromArray($ii = array())
    {
        if ($ii instanceof II) {
            $ii = $ii->toArray();
        } elseif (!is_array($ii)) {
            return $this;
        }
        parent::fromArray($ii);
        if (isset($ii['despesas'])) {
            $this->setDespesas($ii['despesas']);
        } else {
            $this->setDespesas(null);
        }
        if (isset($ii['valor'])) {
            $this->setValor($ii['valor']);
        } else {
            $this->setValor(null);
        }
        if (isset($ii['iof'])) {
            $this->setIOF($ii['iof']);
        } else {
            $this->setIOF(null);
        }
        return $this;
    }

    public function getNode($name = null)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $element = $dom->createElement(is_null($name)?'II':$name);
        $element->appendChild($dom->createElement('vBC', $this->getBase(true)));
        $element->appendChild($dom->createElement('vDespAdu', $this->getDespesas(true)));
        $element->appendChild($dom->createElement('vII', $this->getValor(true)));
        $element->appendChild($dom->createElement('vIOF', $this->getIOF(true)));
        return $element;
    }

    public function loadNode($element, $name = null)
    {
        $name = is_null($name)?'II':$name;
        if ($element->tagName != $name) {
            $_fields = $element->getElementsByTagName($name);
            if ($_fields->length == 0) {
                throw new Exception('Tag "'.$name.'" não encontrada', 404);
            }
            $element = $_fields->item(0);
        }
        $_fields = $element->getElementsByTagName('vBC');
        if ($_fields->length > 0) {
            $base = $_fields->item(0)->nodeValue;
        } else {
            throw new Exception('Tag "vBC" do campo "Base" não encontrada', 404);
        }
        $this->setBase($base);
        $_fields = $element->getElementsByTagName('vDespAdu');
        if ($_fields->length > 0) {
            $despesas = $_fields->item(0)->nodeValue;
        } else {
            throw new Exception('Tag "vDespAdu" do campo "Despesas" não encontrada', 404);
        }
        $this->setDespesas($despesas);
        $_fields = $element->getElementsByTagName('vII');
        if ($_fields->length > 0) {
            $valor = $_fields->item(0)->nodeValue;
        } else {
            throw new Exception('Tag "vII" do campo "Valor" não encontrada', 404);
        }
        $this->setValor($valor);
        $_fields = $element->getElementsByTagName('vIOF');
        if ($_fields->length > 0) {
            $iof = $_fields->item(0)->nodeValue;
        } else {
            throw new Exception('Tag "vIOF" do campo "Iof" não encontrada', 404);
        }
        $this->setIOF($iof);
        return $element;
    }
}
