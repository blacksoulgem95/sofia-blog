<?php

namespace App\Listeners;

use InvalidArgumentException;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Stringable;
use TightenCo\Jigsaw\Jigsaw;

class CustomizeMdParser
{
    public function handle(Jigsaw $jigsaw)
    {
        // Personalizziamo il parser CommonMark per Jigsaw
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        // Aggiungiamo le estensioni standard
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        // Sostituiamo il renderer predefinito per il codice inline
        $environment->addRenderer(Code::class, new CustomInlineCodeRenderer());

        // Sostituiamo il renderer per i blocchi di codice con il nuovo renderer VSCode-like
        $environment->addRenderer(FencedCode::class, new VSCodeEditorRenderer());

        // Sostituiamo il parser di Jigsaw con il nostro parser personalizzato
        $converter = new MarkdownConverter($environment);

        // Salviamo il convertitore nell'oggetto Jigsaw per usarlo in altre parti dell'applicazione
        $jigsaw->app->instance('markdownConverter', $converter);
    }
}

class CustomInlineCodeRenderer implements NodeRendererInterface
{
    /**
     * @param Code $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable
    {
        if (!($node instanceof Code)) {
            throw new InvalidArgumentException('Incompatible node type: ' . get_class($node));
        }

        // Rimuoviamo i backtick dal testo visualizzato
        $content = $node->getLiteral();

        // Assicuriamoci che i backtick iniziali e finali vengano rimossi
        $content = trim($content, '`');

        // Aggiungiamo un attributo data per identificare chiaramente questo elemento come codice inline
        $attrs = [
            'class' => 'inline-code no-backtick',
            'data-inline-code' => 'true',
            'data-no-backtick' => 'true',
        ];

        // Creiamo l'elemento HTML con gli attributi personalizzati
        return new HtmlElement(
            'code',
            $attrs,
            htmlspecialchars($content) // Assicuriamoci che i caratteri speciali vengano codificati correttamente
        );
    }
}

class VSCodeEditorRenderer implements NodeRendererInterface
{
    /**
     * @param FencedCode $node
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable
    {
        if (!($node instanceof FencedCode)) {
            throw new InvalidArgumentException('Incompatible node type: ' . get_class($node));
        }

        $language = $node->getInfo() ?: 'text';
        $content = $node->getLiteral();

        // Il blocco di codice semplice (Prism.js si occuperà dell'evidenziazione)
        $codeElement = new HtmlElement(
            'code',
            ['class' => 'language-' . $language],
            htmlspecialchars($content)
        );

        // Il pre che contiene il blocco di codice
        $preElement = new HtmlElement(
            'pre',
            [],
            $codeElement
        );

        // Ritorniamo l'elemento pre (il nostro script JS si occuperà di trasformarlo in editor VS Code)
        return $preElement;
    }
}
