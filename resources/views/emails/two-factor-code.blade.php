<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Código de Verificação</title>
</head>
<body style="font-family: sans-serif; background: #FDF8F5; padding: 40px;">
    <div style="max-width: 480px; margin: 0 auto; background: white; border-radius: 8px;
                padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <h2 style="color: #5D3A2D; margin-top: 0;">Sweet Values</h2>

        <p>Olá, <strong>{{ $user->name }}</strong>!</p>

        <p>Use o código abaixo para concluir seu login. Ele expira em <strong>10 minutos</strong>.</p>

        <div style="font-size: 36px; font-weight: bold; letter-spacing: 12px;
                    color: #5D3A2D; text-align: center; padding: 20px 0;">
            {{ $user->two_factor_code }}
        </div>

        <p style="color: #888; font-size: 13px;">
            Se você não tentou fazer login, ignore este e-mail.
        </p>
    </div>
</body>
</html>
