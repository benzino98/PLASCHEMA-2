<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLASCHEMA Deployment & Maintenance Console</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fira-code:400,600|inter:400,500,600,700" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #0b1120;
            color: #e2e8f0;
            padding: 2rem 1rem;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #1e293b;
        }
        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #38bdf8;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-prod { background: #1e3a5f; color: #38bdf8; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .card {
            background: #131c31;
            border: 1px solid #1e293b;
            border-radius: 0.75rem;
            padding: 1.25rem;
        }
        .card h3 {
            font-size: 0.8rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        .card .value {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .text-green { color: #4ade80; }
        .text-red { color: #f87171; }
        .text-amber { color: #fbbf24; }
        .text-muted { color: #64748b; font-size: 0.85rem; font-weight: 400; }
        .actions-panel {
            background: #131c31;
            border: 1px solid #1e293b;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .actions-title {
            font-size: 1rem;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 1rem;
        }
        .actions-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        button.btn {
            appearance: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.7rem 1.25rem;
            border-radius: 0.5rem;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        button.btn:hover { transform: translateY(-1px); }
        button.btn-primary { background: #0284c7; color: white; }
        button.btn-primary:hover { background: #0369a1; }
        button.btn-success { background: #16a34a; color: white; }
        button.btn-success:hover { background: #15803d; }
        button.btn-emerald { background: #059669; color: white; }
        button.btn-emerald:hover { background: #047857; }
        button.btn-amber { background: #d97706; color: white; }
        button.btn-amber:hover { background: #b45309; }
        button.btn-secondary { background: #334155; color: #f1f5f9; }
        button.btn-secondary:hover { background: #475569; }
        .terminal-panel {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        .terminal-header {
            background: #0f172a;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .terminal-dots {
            display: flex;
            gap: 0.35rem;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }
        .terminal-title {
            font-family: 'Fira Code', monospace;
            font-size: 0.8rem;
            color: #94a3b8;
        }
        .terminal-body {
            padding: 1.25rem;
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
            line-height: 1.6;
            color: #4ade80;
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 450px;
            overflow-y: auto;
        }
        .notice {
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(14, 165, 233, 0.08);
            border-left: 3px solid #0284c7;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div>
                <h1>⚡ PLASCHEMA Deploy & Maintenance</h1>
                <p class="text-muted" style="margin-top: 0.25rem;">Server Management Console for Shared Hosting</p>
            </div>
            <div>
                <span class="badge badge-prod">{{ $status['app_env'] }}</span>
            </div>
        </header>

        <section class="grid">
            <div class="card">
                <h3>Database</h3>
                <div class="value {{ $status['db_connected'] ? 'text-green' : 'text-red' }}">
                    {{ $status['db_connected'] ? '● Connected' : '✕ Disconnected' }}
                </div>
                <div class="text-muted" style="margin-top: 0.3rem;">
                    {{ $status['db_connected'] ? ($status['db_name'] ?? 'Ready') : ($status['db_error'] ?? 'Check .env') }}
                </div>
            </div>

            <div class="card">
                <h3>Storage Symlink</h3>
                <div class="value {{ $status['storage_linked'] ? 'text-green' : 'text-amber' }}">
                    {{ $status['storage_linked'] ? '● Linked' : '▲ Not Linked' }}
                </div>
                <div class="text-muted" style="margin-top: 0.3rem;">public/storage</div>
            </div>

            <div class="card">
                <h3>PHP / Framework</h3>
                <div class="value" style="color: #cbd5e1;">
                    PHP {{ $status['php_version'] }}
                </div>
                <div class="text-muted" style="margin-top: 0.3rem;">Laravel {{ $status['laravel_version'] }}</div>
            </div>

            <div class="card">
                <h3>Core / Web Root</h3>
                <div class="value" style="font-size: 0.85rem; font-family: monospace; color: #94a3b8; word-break: break-all;">
                    {{ basename($status['base_path']) }} / {{ basename($status['public_path']) }}
                </div>
                <div class="text-muted" style="margin-top: 0.3rem;">Separated Architecture</div>
            </div>
        </section>

        <section class="actions-panel">
            <div class="actions-title">Server Actions</div>
            <div class="actions-grid">
                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="all">
                    <button type="submit" class="btn btn-primary">
                        🚀 Run All Post-Deploy Tasks
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="migrate">
                    <button type="submit" class="btn btn-success">
                        🗄️ Run Migrations (migrate --force)
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}" onsubmit="return confirm('Run database seeders? This will insert default records.');">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="seed">
                    <button type="submit" class="btn btn-emerald">
                        🌱 Seed Database (db:seed --force)
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="storage_link">
                    <button type="submit" class="btn btn-amber">
                        🔗 Create Storage Link
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="optimize">
                    <button type="submit" class="btn btn-secondary">
                        ⚡ Cache & Optimize
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn btn-secondary">
                        🧹 Clear Cache
                    </button>
                </form>

                <form method="POST" action="{{ route('deploy.run') }}">
                    <input type="hidden" name="key" value="{{ $key }}">
                    <input type="hidden" name="action" value="status">
                    <button type="submit" class="btn btn-secondary">
                        📋 Migration Status
                    </button>
                </form>
            </div>
        </section>

        <section class="terminal-panel">
            <div class="terminal-header">
                <div class="terminal-dots">
                    <span class="dot dot-red"></span>
                    <span class="dot dot-yellow"></span>
                    <span class="dot dot-green"></span>
                </div>
                <div class="terminal-title">output: {{ $lastAction ?? 'console' }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ now()->toFormattedDateString() }}</div>
            </div>
            <div class="terminal-body">{{ $output }}</div>
        </section>

        <div class="notice">
            <strong>Security Notice:</strong> This maintenance console is protected by <code>DEPLOY_KEY</code>. Keep this key secret. You can also trigger these actions automatically in GitHub Actions by passing <code>X-Deploy-Key: {{ $key }}</code> to <code>/_deploy/run</code>.
        </div>
    </div>
</body>
</html>
