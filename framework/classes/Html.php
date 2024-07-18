<?php 
/**
 * Define os tipos de Tags HTML disponíveis
 */

class TipoTag {
	protected $nome;
	protected $finaliza = true;

	public function __construct($nome, $finaliza) {
		$this->nome = $nome;
		$this->finaliza = (bool) $finaliza;
	}

	public function getNome() {
		return $this->nome;
	}

	public function getFinaliza() {
		return (bool) $this->finaliza;
	}
}


class TiposPadrao {
    private $tipos = array();

    public function __construct() {
        $this->inicializa();
    }

    public function inicializa() {
        $this->tipos = array(
            'a' => new TipoTag("a"),
            'area' => new TipoTag("area", false),
            'base' => new TipoTag("base", false),
            'body' => new TipoTag("body"),
            'br' => new TipoTag("br", false),
            'button' => new TipoTag("button"),
            'comment' => new TipoTag("comment", false),
            'div' => new TipoTag("div"),
            'form' => new TipoTag("form"),
            'head' => new TipoTag("head"),
            'hr' => new TipoTag("hr", false),
            'html' => new TipoTag("html"),
            'iframe' => new TipoTag("iframe"),
            'img' => new TipoTag("img", false),
            'input' => new TipoTag("input", false),
            'link' => new TipoTag("link", false),
            'map' => new TipoTag("map"),
            'meta' => new TipoTag("meta", false),
            'option' => new TipoTag("option"),
            'p' => new TipoTag("p"),
            'script' => new TipoTag("script"),
            'select' => new TipoTag("select"),
            'span' => new TipoTag("span"),
            'style' => new TipoTag("style"),
            'table' => new TipoTag("table"),
            'tbody' => new TipoTag("tbody"),
            'td' => new TipoTag("td"),
            'textarea' => new TipoTag("textarea"),
            'th' => new TipoTag("th"),
            'title' => new TipoTag("title"),
            'tr' => new TipoTag("tr")
        );
    }

    public function getTipo($tipo) {
        return isset($this->tipos[$tipo]) ? $this->tipos[$tipo] : null;
    }
}


?>
