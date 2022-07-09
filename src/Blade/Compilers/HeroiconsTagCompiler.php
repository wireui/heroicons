<?php

namespace WireUi\Heroicons\Blade\Compilers;

use Illuminate\View\Compilers\ComponentTagCompiler;

class HeroiconsTagCompiler extends ComponentTagCompiler
{
    private function processOpeningTags(string $pattern, string $value): string
    {
        return preg_replace_callback($pattern, function (array $matches) {
            $icon       = $matches[1];
            $attributes = $matches['attributes'];
            $variant    = null;

            if (str_starts_with($icon, 'outline.')) {
                $variant = 'outline';
                $icon    = substr($icon, 8);
            }

            if (str_starts_with($icon, 'solid.')) {
                $variant = 'solid';
                $icon    = substr($icon, 6);
            }

            return str_replace(
                search: ' variant="" ',
                replace: '',
                subject: "<x-icons.heroicons name=\"{$icon}\" variant=\"{$variant}\" {$attributes} />"
            );
        }, $value);
    }

    protected function compileSelfClosingTags(string $value): string
    {
        $pattern = "/
            <
                \s*
                x-icons\.heroicons\.([\w\-\.]*)
                \s*
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                [\w\-:.@]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        \'[^\']*\'
                                        |
                                        [^\'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
            \/>
        /x";

        return $this->processOpeningTags($pattern, $value);
    }

    protected function compileOpeningTags(string $value): string
    {
        $pattern = "/
            <
                \s*
                x-icons\.heroicons\.([\w\-\.]*)
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                [\w\-:.@]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        \'[^\']*\'
                                        |
                                        [^\'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
                (?<![\/=\-])
            >
        /x";

        return $this->processOpeningTags($pattern, $value);
    }

    protected function compileClosingTags(string $value): string
    {
        return preg_replace(
            pattern: '/<\/\s*x[-\:](icons\.heroicons\.)[\w\-\:\.]*\s*>/',
            replacement: '',
            subject: $value
        );
    }
}
