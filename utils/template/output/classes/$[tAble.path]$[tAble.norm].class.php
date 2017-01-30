<?php
/**
 * MIT License
 *
 * Copyright (c) 2016 MZ Desenvolvimento de Sistemas LTDA
 *
 * @author  Francimar Alves <mazinsw@gmail.com>
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
$[table.if(package)]
namespace $[table.package];
$[table.end]

$[table.if(comment)]
/**
$[table.each(comment)]
 * $[Table.comment]
$[table.end]
 */
$[table.end]
class $[tAble.norm]$[table.if(inherited)] extends $[table.inherited]$[table.else] implements NodeInterface$[table.end]

{
$[field.each(all)]
$[field.if(enum)]

$[field.if(comment)]
    /**
$[field.each(comment)]
     * $[Field.comment]
$[field.end]
     */
$[field.end]
$[field.each(option)]
    const $[FIELD.unix]_$[FIELD.option.norm] = '$[field.option]';
$[field.end]
$[field.end]
$[field.end]

$[field.each(all)]
    private $$[field.unix];
$[field.end]

    public function __construct($$[table.unix] = array())
    {
$[table.if(inherited)]
        parent::__construct($$[table.unix]);
$[table.else]
        $this->fromArray($$[table.unix]);
$[table.end]
    }
$[field.each(all)]

$[field.if(comment)]
    /**
$[field.each(comment)]
     * $[Field.comment]
$[field.end]
     */
$[field.end]
    public function get$[fIeld.norm]($[field.if(searchable)]$[field.else]$normalize = false$[field.end])
    {
$[field.if(searchable)]
        return $this->$[field.unix];
$[field.else]
        if (!$normalize) {
            return $this->$[field.unix];
        }
$[field.if(currency)]
        return Util::toCurrency($this->$[field.unix]);
$[field.else.if(float|double)]
        return Util::toFloat($this->$[field.unix]);
$[field.else.if(datetime)]
        return Util::toDateTime($this->$[field.unix]);
$[field.else.if(enum)]
        switch ($this->$[field.unix]) {
$[field.each(option)]
            case self::$[FIELD.unix]_$[FIELD.option.norm]:
                return '$[fIeld.option.name]';
$[field.end]
        }
        return $this->$[field.unix];
$[field.else.if(boolean)]
        return $this->is$[fIeld.norm]()?'1':'0';
$[field.else]
        return $this->$[field.unix];
$[field.end]
$[field.end]
    }
$[field.if(boolean)]

$[field.if(comment)]
    /**
$[field.each(comment)]
     * $[Field.comment]
$[field.end]
     */
$[field.end]
    public function is$[fIeld.norm]()
    {
        return $this->$[field.unix] == 'Y';
    }
$[field.end]

    public function set$[fIeld.norm]($$[field.unix])
    {
$[field.if(enum)]
        switch ($$[field.unix]) {
$[field.each(option)]
            case '$[fIeld.option.name]':
                $$[field.unix] = self::$[FIELD.unix]_$[FIELD.option.norm];
                break;
$[field.end]
        }
$[field.else.if(integer)]
        if (trim($$[field.unix]) != '') {
            $$[field.unix] = intval($$[field.unix]);
        }
$[field.else.if(currency)]
        if (trim($$[field.unix]) != '') {
            $$[field.unix] = floatval($$[field.unix]);
        }
$[field.else.if(float|double)]
        if (trim($$[field.unix]) != '') {
            $$[field.unix] = floatval($$[field.unix]);
        }
$[field.else.if(datetime)]
        if ($[field.if(null)]trim($$[field.unix]) != '' && $[field.end]!is_numeric($$[field.unix])) {
            $$[field.unix] = strtotime($$[field.unix]);
        }
$[field.else.if(boolean)]
        if ($[field.if(null)]trim($$[field.unix]) != '' && $[field.end]!in_array($$[field.unix], array('N', 'Y'))) {
            $$[field.unix] = $$[field.unix]?'Y':'N';
        }
$[field.end]
        $this->$[field.unix] = $$[field.unix];
        return $this;
    }
$[field.if(descriptor)]
$[field.else.if(searchable)]

    public function add$[Field.unix.plural]($$[field.unix.plural])
    {
        $this->$[field.unix][] = $$[field.unix.plural];
        return $this;
    }
$[field.end]
$[field.end]

    public function toArray()
    {
$[table.if(inherited)]
        $$[table.unix] = parent::toArray();
$[table.else]
        $$[table.unix] = array();
$[table.end]
$[field.each(all)]
        $$[table.unix]['$[field]'] = $this->get$[fIeld.norm]();
$[field.end]
        return $$[table.unix];
    }

    public function fromArray($$[table.unix] = array())
    {
        if ($$[table.unix] instanceof $[tAble.norm]) {
            $$[table.unix] = $$[table.unix]->toArray();
        } elseif (!is_array($$[table.unix])) {
            return $this;
        }
$[table.if(inherited)]
        parent::fromArray($$[table.unix]);
$[table.end]
$[field.each(all)]
$[field.if(default)]
        if (!isset($$[table.unix]['$[field]']) || is_null($$[table.unix]['$[field]'])) {
            $this->set$[fIeld.norm]($[fIeld.info]);
        } else {
            $this->set$[fIeld.norm]($$[table.unix]['$[field]']);
        }
$[field.else]
        if (isset($$[table.unix]['$[field]'])) {
            $this->set$[fIeld.norm]($$[table.unix]['$[field]']);
        } else {
            $this->set$[fIeld.norm](null);
        }
$[field.end]
$[field.end]
        return $this;
    }

    public function getNode($name = null)
    {
$[table.if(inherited)]
        $element = parent::getNode(is_null($name)?'$[tAble.style]':$name);
        $dom = $element->ownerDocument;
$[table.else]
        $dom = new DOMDocument('1.0', 'UTF-8');
        $element = $dom->createElement(is_null($name)?'$[tAble.style]':$name);
$[table.end]
$[field.each(all)]
$[field.if(null)]
        if (!is_null($this->get$[fIeld.norm]())) {
$[field.end]
$[field.if(descriptor)]
    $[field.if(null)]    $[field.end]    $$[field.unix] = $this->get$[fIeld.norm]()->getNode();
    $[field.if(null)]    $[field.end]    $$[field.unix] = $dom->importNode($$[field.unix], true);
    $[field.if(null)]    $[field.end]    $element->appendChild($$[field.unix]);
$[field.else.if(searchable)]
    $[field.if(null)]    $[field.end]    $_$[field.unix] = $this->get$[fIeld.norm]();
    $[field.if(null)]    $[field.end]    $$[field.unix] = $dom->createElement('$[fIeld.style]');
    $[field.if(null)]    $[field.end]    foreach ($_$[field.unix] as $_$[field.unix.plural]) {
    $[field.if(null)]    $[field.end]        $$[field.unix.plural] = $_$[field.unix.plural]->getNode();
    $[field.if(null)]    $[field.end]        $$[field.unix.plural] = $dom->importNode($$[field.unix.plural], true);
    $[field.if(null)]    $[field.end]        $$[field.unix]->appendChild($$[field.unix.plural]);
    $[field.if(null)]    $[field.end]    }
    $[field.if(null)]    $[field.end]    $element->appendChild($$[field.unix]);
$[field.else]
    $[field.if(null)]    $[field.end]    $element->appendChild($dom->createElement('$[fIeld.style]', $this->get$[fIeld.norm](true)));
$[field.end]
$[field.if(null)]
        }
$[field.end]
$[field.end]
        return $element;
    }

    public function loadNode($element, $name = null)
    {
        $name = is_null($name)?'$[tAble.style]':$name;
$[table.if(inherited)]
        $element = parent::loadNode($element, $name);
$[table.else]
        if ($element->tagName != $name) {
            $_fields = $element->getElementsByTagName($name);
            if ($_fields->length == 0) {
                throw new Exception('Tag "'.$name.'" d$[table.gender] $[tAble.norm] não encontrada', 404);
            }
            $element = $_fields->item(0);
        }
$[table.end]
$[field.each(all)]
$[field.if(descriptor)]
        $_fields = $element->getElementsByTagName('$[fIeld.style]');
$[field.if(null)]
        $$[field.unix] = null;
$[field.end]
        if ($_fields->length > 0) {
$[field.if(default)]
            $$[field.unix] = $[fIeld.info];
$[field.else]
            $$[field.unix] = new $[fIeld.norm](); // TODO: predictable class name
$[field.end]
            $$[field.unix]->loadNode($_fields->item(0), '$[fIeld.style]');
$[field.if(null)]
        }
$[field.else]
        } else {
            throw new Exception('Tag "$[fIeld.style]" do objeto "$[fIeld.norm]" não encontrada n$[table.gender] $[tAble.norm]', 404);
        }
$[field.end]
        $this->set$[fIeld.norm]($$[field.unix]);
$[field.else.if(searchable)]
        $$[field.unix] = array();
        $_fields = $element->getElementsByTagName('$[fIeld.norm.plural]'); // TODO: predictable tag name
        if ($_fields->length > 0) {
            $_items = $_fields->item(0)->getElementsByTagName('$[fIeld.style]');
            foreach ($_items as $_item) {
$[field.if(default)]
                $$[field.unix.plural] = $[fIeld.info];
$[field.else]
                $$[field.unix.plural] = new $[fIeld.norm](); // TODO: predictable class name
$[field.end]
                $$[field.unix.plural]->loadNode($_item, '$[fIeld.style]');
                $$[field.unix][] = $$[field.unix.plural];
            }
$[field.if(null)]
        }
$[field.else]
        } else {
            throw new Exception('Tag "$[fIeld.norm.plural]" da lista de "$[fIeld.norm]" não encontrada n$[table.gender] $[tAble.norm]', 404); // TODO: predictable tag name
        }
$[field.end]
        $this->set$[fIeld.norm]($$[field.unix]);
$[field.else]
        $_fields = $element->getElementsByTagName('$[fIeld.style]');
$[field.if(null)]
        $$[field.unix] = null;
$[field.end]
        if ($_fields->length > 0) {
            $$[field.unix] = $_fields->item(0)->nodeValue;
$[field.if(null)]
        }
$[field.else]
        } else {
            throw new Exception('Tag "$[fIeld.style]" do campo "$[fIeld.norm]" não encontrada n$[table.gender] $[tAble.norm]', 404);
        }
$[field.end]
        $this->set$[fIeld.norm]($$[field.unix]);
$[field.end]
$[field.end]
        return $element;
    }
}
