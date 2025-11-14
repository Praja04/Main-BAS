<!DOCTYPE html>
<html>

<head>
    <title>Portal Login - {{ $portal->portal_name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .container {
            text-align: center;
            background: white;
            padding: 50px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
        }

        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        h2 {
            color: #333;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 600;
        }

        .portal-name {
            color: #667eea;
            font-size: 18px;
            font-weight: 500;
            margin: 15px 0 5px 0;
        }

        .waiting-text {
            color: #666;
            margin: 15px 0;
            font-size: 14px;
        }

        .info-box {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            text-align: left;
        }

        .info-item {
            color: #666;
            font-size: 13px;
            margin: 8px 0;
        }

        .label {
            color: #999;
            font-weight: 500;
        }

        .error-message {
            color: #e74c3c;
            background: #fadbd8;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            display: none;
        }

        .debug-info {
            background: #ecf0f1;
            padding: 10px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 11px;
            color: #7f8c8d;
            text-align: left;
            max-height: 150px;
            overflow-y: auto;
        }

        .manual-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
        }

        .manual-button:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="spinner"></div>
        <h2>Logging in...</h2>
        <p class="portal-name">{{ $portal->portal_name }}</p>
        <p class="waiting-text">Mencoba login ke portal...</p>

        <div class="info-box">
            <div class="info-item">
                <span class="label">Username:</span> {{ $portal->username }}
            </div>
            <div class="info-item">
                <span class="label">Portal:</span> {{ $portal->portal_url }}
            </div>
        </div>

        <div class="error-message" id="errorMessage">
            ✗ Login gagal. Silakan login manual melalui tombol di bawah.
        </div>

        <a href="{{ $portal->portal_url }}" target="_blank" class="manual-button">
            🔓 Buka Portal Manual
        </a>

        <div class="debug-info" id="debugInfo" style="display: none;">
            <strong>Debug Info:</strong><br>
            <span id="debugLog"></span>
        </div>
    </div>

    <!-- Hidden Form untuk Auto-Submit -->
    <form id="loginForm" method="POST" style="display:none;">
        <input type="hidden" name="username" value="{{ $portal->username }}">
        <input type="hidden" name="password" value="{{ $password }}">
    </form>

    <script>
        const config = {
            portalUrl: '{{ $portalUrl }}',
            username: '{{ $portal->username }}',
            loginEndpoints: @json($loginEndpoints)
        };

        let debugLog = [];

        function log(msg) {
            console.log(msg);
            debugLog.push(msg);
            document.getElementById('debugLog').innerText = debugLog.join('<br>');
        }

        async function tryLogin(endpoint, attempt = 1) {
            log(`Attempt ${attempt}: Trying ${endpoint}`);

            try {
                const formData = new FormData();
                formData.append('username', config.username);
                formData.append('password', document.querySelector('input[name="password"]').value);

                const response = await fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow',
                    credentials: 'include', // Include cookies
                });

                log(`Response status: ${response.status}`);

                if (response.ok || response.status === 301 || response.status === 302) {
                    log('Login successful! Redirecting...');
                    // Tunggu sebentar baru redirect
                    setTimeout(() => {
                        window.location.href = config.portalUrl;
                    }, 1000);
                    return true;
                }

                return false;

            } catch (err) {
                log(`Error: ${err.message}`);
                return false;
            }
        }

        async function autoLogin() {
            log('Starting auto-login process...');

            // Coba endpoint satu per satu
            for (let i = 0; i < config.loginEndpoints.length; i++) {
                const success = await tryLogin(config.loginEndpoints[i], i + 1);
                if (success) {
                    return;
                }
                // Tunggu 1 detik sebelum coba endpoint berikutnya
                await new Promise(r => setTimeout(r, 1000));
            }

            // Kalau semua gagal
            log('All login attempts failed!');
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('debugInfo').style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                autoLogin();
            }, 1000);
        });
    </script>
</body>

</html>