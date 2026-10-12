<?php
declare(strict_types=1);

// Short-lived, server-side form state. Personal data never goes in a redirect URL or event log.
function obra_form_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) { return; }
    session_name('obra_form');
    session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', 'httponly' => true, 'samesite' => 'Lax']);
    session_start();
    header('Cache-Control: private, no-store');
    // Los datos del formulario vencen a los 30 minutos; el token CSRF dura lo que la sesion.
    $csrf = $_SESSION['obra_form']['csrf'] ?? '';
    if (($_SESSION['obra_form']['expires'] ?? 0) < time()) { unset($_SESSION['obra_form']); }
    $_SESSION['obra_form']['csrf'] = is_string($csrf) && preg_match('/^[a-f0-9]{32}$/', $csrf) ? $csrf : bin2hex(random_bytes(16));
}

function obra_form_csrf(): string
{
    return (string) ($_SESSION['obra_form']['csrf'] ?? '');
}

/** @return array<string, mixed> */
function obra_form_values(): array
{
    return $_SESSION['obra_form']['values'] ?? [];
}

/** @return array<string, string> */
function obra_form_errors(): array
{
    return $_SESSION['obra_form']['errors'] ?? [];
}

/**
 * @param array<string, mixed> $values
 * @param array<string, string> $errors
 */
function obra_form_save(array $values, array $errors = []): void
{
    $_SESSION['obra_form'] = ['values' => $values, 'errors' => $errors, 'expires' => time() + 1800, 'csrf' => obra_form_csrf()];
}

/** @param array<string, string> $errors */
function obra_field_error(string $field, array $errors): string
{
    return isset($errors[$field]) ? ' aria-invalid="true" aria-describedby="error-' . h($field) . '"' : '';
}

/** @param array<string, string> $errors */
function obra_error_text(string $field, array $errors): void
{
    if (isset($errors[$field])) { ?><span class="field-error" id="error-<?= h($field) ?>"><?= h($errors[$field]) ?></span><?php }
}
