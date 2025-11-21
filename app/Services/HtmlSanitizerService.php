<?php

namespace App\Services;

class HtmlSanitizerService
{
    /**
     * Allowed HTML tags for rich text content
     */
    protected array $allowedTags = [
        'p', 'br', 'strong', 'em', 'u', 's', 'strike',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'a', 'img',
        'blockquote', 'code', 'pre',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'div', 'span'
    ];

    /**
     * Allowed attributes per tag
     */
    protected array $allowedAttributes = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'table' => ['border', 'cellpadding', 'cellspacing'],
        'td' => ['colspan', 'rowspan'],
        'th' => ['colspan', 'rowspan'],
    ];

    /**
     * Sanitize HTML content
     *
     * @param string|null $html
     * @return string|null
     */
    public function sanitize(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        // Remove dangerous tags and scripts
        $html = $this->removeDangerousTags($html);

        // Remove dangerous attributes (onclick, onerror, etc.)
        $html = $this->removeDangerousAttributes($html);

        // Clean up allowed tags
        $html = $this->cleanAllowedTags($html);

        return $html;
    }

    /**
     * Remove dangerous HTML tags
     *
     * @param string $html
     * @return string
     */
    protected function removeDangerousTags(string $html): string
    {
        $dangerousTags = [
            'script', 'iframe', 'object', 'embed',
            'applet', 'meta', 'link', 'style',
            'form', 'input', 'button', 'select', 'textarea'
        ];

        foreach ($dangerousTags as $tag) {
            // Remove opening and closing tags with content
            $html = preg_replace('/<' . $tag . '\b[^>]*>.*?<\/' . $tag . '>/is', '', $html);
            // Remove self-closing tags
            $html = preg_replace('/<' . $tag . '\b[^>]*\/>/is', '', $html);
        }

        return $html;
    }

    /**
     * Remove dangerous attributes from HTML
     *
     * @param string $html
     * @return string
     */
    protected function removeDangerousAttributes(string $html): string
    {
        // Remove event handlers (onclick, onload, onerror, etc.)
        $html = preg_replace('/(<[^>]+)\s+on\w+\s*=\s*["\'][^"\']*["\']([^>]*>)/i', '$1$2', $html);

        // Remove javascript: protocol in href and src
        $html = preg_replace('/(<[^>]+)(href|src)\s*=\s*["\']javascript:[^"\']*["\']([^>]*>)/i', '$1$3', $html);

        // Remove data: protocol (can be used for XSS)
        $html = preg_replace('/(<[^>]+)(href|src)\s*=\s*["\']data:[^"\']*["\']([^>]*>)/i', '$1$3', $html);

        // Remove style attribute (can contain javascript)
        $html = preg_replace('/(<[^>]+)\s+style\s*=\s*["\'][^"\']*["\']([^>]*>)/i', '$1$2', $html);

        return $html;
    }

    /**
     * Clean and validate allowed tags
     *
     * @param string $html
     * @return string
     */
    protected function cleanAllowedTags(string $html): string
    {
        // Build allowed tags string for strip_tags
        $allowedTagsString = '<' . implode('><', $this->allowedTags) . '>';

        // Strip all tags except allowed ones
        $html = strip_tags($html, $allowedTagsString);

        // Additional cleaning for specific tags
        $html = $this->cleanLinkTags($html);
        $html = $this->cleanImageTags($html);

        return $html;
    }

    /**
     * Clean and validate anchor tags
     *
     * @param string $html
     * @return string
     */
    protected function cleanLinkTags(string $html): string
    {
        // Ensure external links have rel="noopener noreferrer"
        $html = preg_replace_callback(
            '/<a\s+([^>]*)>/i',
            function ($matches) {
                $attributes = $matches[1];

                // Check if target="_blank" exists
                if (preg_match('/target\s*=\s*["\']_blank["\']/i', $attributes)) {
                    // Add or update rel attribute
                    if (preg_match('/rel\s*=\s*["\']([^"\']*)["\']/i', $attributes, $relMatch)) {
                        $relValue = $relMatch[1];
                        if (strpos($relValue, 'noopener') === false) {
                            $relValue .= ' noopener';
                        }
                        if (strpos($relValue, 'noreferrer') === false) {
                            $relValue .= ' noreferrer';
                        }
                        $attributes = preg_replace(
                            '/rel\s*=\s*["\'][^"\']*["\']/i',
                            'rel="' . trim($relValue) . '"',
                            $attributes
                        );
                    } else {
                        $attributes .= ' rel="noopener noreferrer"';
                    }
                }

                return '<a ' . $attributes . '>';
            },
            $html
        );

        return $html;
    }

    /**
     * Clean and validate image tags
     *
     * @param string $html
     * @return string
     */
    protected function cleanImageTags(string $html): string
    {
        // Ensure images have alt attribute
        $html = preg_replace_callback(
            '/<img\s+([^>]*)>/i',
            function ($matches) {
                $attributes = $matches[1];

                // Add alt if not exists
                if (!preg_match('/alt\s*=\s*["\']/i', $attributes)) {
                    $attributes .= ' alt=""';
                }

                // Add loading="lazy" for better performance
                if (!preg_match('/loading\s*=\s*["\']/i', $attributes)) {
                    $attributes .= ' loading="lazy"';
                }

                return '<img ' . $attributes . '>';
            },
            $html
        );

        return $html;
    }

    /**
     * Sanitize for preview (more strict)
     *
     * @param string|null $html
     * @param int $length
     * @return string|null
     */
    public function sanitizeForPreview(?string $html, int $length = 200): ?string
    {
        if (empty($html)) {
            return $html;
        }

        // Strip all tags
        $text = strip_tags($html);

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // Trim and limit length
        $text = trim($text);
        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length) . '...';
        }

        return $text;
    }

    /**
     * Check if HTML contains dangerous content
     *
     * @param string|null $html
     * @return bool
     */
    public function isDangerous(?string $html): bool
    {
        if (empty($html)) {
            return false;
        }

        // Check for script tags
        if (preg_match('/<script\b[^>]*>/i', $html)) {
            return true;
        }

        // Check for event handlers
        if (preg_match('/\son\w+\s*=/i', $html)) {
            return true;
        }

        // Check for javascript: protocol
        if (preg_match('/javascript:/i', $html)) {
            return true;
        }

        // Check for iframe
        if (preg_match('/<iframe\b[^>]*>/i', $html)) {
            return true;
        }

        return false;
    }
}
