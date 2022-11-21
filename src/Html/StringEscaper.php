<?php

namespace Html;

trait StringEscaper
{
    /** Protéger les caractères spéciaux pouvant dégrader la page Web
     * @param ?string $string La chaîne à protéger
     * @return string La chaîne protégée
     */
    public static function escapeString(?string $text = null): string
    {
        if ($text == null) {
            $res = "";
        } else {
            $res = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);
        }
        return $res;
    }

    public static function stripTagsAndTrim(?string $text = null)
    {
        if ($text == null) {
            $res = null;
        } else {
            $res = trim(strip_tags($text));
        }
        return $res;
    }
}
