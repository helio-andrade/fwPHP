<?php 
/**
 * Define os tipos de Tags HTML disponíveis
 */

class TipoTag {
    private string $nome;
    private bool $finaliza;

    public function __construct(string $nome, bool $finaliza = true) {
        $this->nome = $nome;
        $this->finaliza = $finaliza;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getFinaliza(): bool {
        return $this->finaliza;
    }
}

class TiposPadrao {
    private array $tipos = [];

    public function __construct() {
        $this->inicializa();
    }

    private function inicializa(): void {
        $this->tipos = [
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
        ];
    }

    public function getTipo(string $tipo): ?TipoTag {
        return $this->tipos[$tipo] ?? null;
    }
}

/**
 * Define um Atributo para o marcador HTML relacionado
 */
class Atributo {
    private string $nome;
    private ?string $valor;

    public function __construct(string $nome, ?string $valor = null) {
        $this->nome = $nome;
        $this->valor = $valor;
    }

    public function getAtributo(): string {
        // Formato: atributo.nome[=atributo.valor]
        return $this->valor !== null 
            ? "{$this->nome}=\"{$this->valor}\"" 
            : $this->nome;
    }
}
?>
