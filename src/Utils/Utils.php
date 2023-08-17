<?php


function generateInitials(string $name): string {
    $words = explode(' ', $name);
    $initials = '';

    $firstWord = $words[0] ?? '';
    $lastWord = $words[count($words) - 1] ?? '';

    if (!empty($firstWord)) {
        $initials .= strtoupper(substr($firstWord, 0, 1));
    }

    if (!empty($lastWord) && strlen($initials) < 2) {
        $initials .= strtoupper(substr($lastWord, 0, 1));
    }

    return $initials;
}