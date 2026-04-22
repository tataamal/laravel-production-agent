<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Copilot — ERP Assistant</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #080e1a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
        }

        /* ── LOGIN ── */
        .login-wrap {
            width: 100%;
            max-width: 440px;
            padding: 24px;
        }

        .login-card {
            background: #111827;
            border: 1px solid rgba(148,163,184,.1);
            border-radius: 24px;
            padding: 40px 40px 44px;
            box-shadow: 0 32px 64px rgba(0,0,0,.6), 0 0 0 1px rgba(255,255,255,.03);
        }

        .brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            box-shadow: 0 8px 24px rgba(99,102,241,.35);
        }

        .login-title { font-size: 26px; font-weight: 800; letter-spacing: -.5px; margin-bottom: 6px; }
        .login-subtitle { font-size: 14px; color: #64748b; font-weight: 500; margin-bottom: 36px; }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13px; font-weight: 600;
            color: #94a3b8;
            margin-bottom: 7px;
            letter-spacing: .01em;
        }

        .form-input {
            width: 100%;
            background: #0d1526;
            border: 1px solid rgba(148,163,184,.12);
            border-radius: 12px;
            padding: 13px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: #f1f5f9;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            border-color: rgba(99,102,241,.5);
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
        .form-input::placeholder { color: #334155; }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 12px;
            padding: 14px;
            margin-top: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            letter-spacing: -.01em;
            transition: opacity .2s, transform .1s;
            box-shadow: 0 4px 20px rgba(99,102,241,.3);
        }
        .btn-login:hover { opacity: .9; }
        .btn-login:active { transform: scale(.99); }

        .alert-error {
            background: rgba(239,68,68,.08);
            border: 1px solid rgba(239,68,68,.25);
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 13px;
            color: #fca5a5;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 8px;
        }

        /* ── CHAT LAYOUT ── */
        .chat-layout {
            display: flex; flex-direction: column;
            height: 100vh; width: 100%;
            max-width: 960px;
        }

        .chat-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 28px;
            border-bottom: 1px solid rgba(148,163,184,.07);
            background: rgba(8,14,26,.9);
            backdrop-filter: blur(12px);
            flex-shrink: 0;
        }

        .header-brand { display: flex; align-items: center; gap: 12px; }

        .header-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(99,102,241,.3);
            flex-shrink: 0;
        }

        .header-name { font-size: 16px; font-weight: 800; letter-spacing: -.3px; }
        .header-sub { font-size: 11.5px; color: #475569; font-weight: 500; margin-top: 1px; }

        .header-right { display: flex; align-items: center; gap: 12px; }
        .header-user { font-size: 13px; color: #475569; font-weight: 500; }

        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            background: rgba(148,163,184,.06);
            border: 1px solid rgba(148,163,184,.1);
            border-radius: 9px;
            padding: 7px 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-logout:hover { background: rgba(148,163,184,.1); color: #94a3b8; }

        /* ── MESSAGES ── */
        .messages-wrap {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 8px;
            display: flex; flex-direction: column;
            gap: 22px;
        }
        .messages-wrap::-webkit-scrollbar { width: 3px; }
        .messages-wrap::-webkit-scrollbar-thumb { background: rgba(148,163,184,.15); border-radius: 4px; }

        /* Welcome */
        .welcome {
            flex: 1;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            padding: 60px 20px;
            min-height: 400px;
        }
        .welcome-icon-wrap {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, rgba(99,102,241,.12), rgba(139,92,246,.12));
            border: 1px solid rgba(99,102,241,.2);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
        }
        .welcome-heading { font-size: 23px; font-weight: 800; letter-spacing: -.4px; margin-bottom: 10px; }
        .welcome-desc { font-size: 14px; color: #475569; line-height: 1.7; max-width: 380px; font-weight: 500; }

        .suggestions { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-top: 28px; }
        .chip {
            background: rgba(99,102,241,.07);
            border: 1px solid rgba(99,102,241,.18);
            border-radius: 100px;
            padding: 9px 18px;
            font-size: 13px; font-weight: 600;
            color: #818cf8;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s;
        }
        .chip:hover { background: rgba(99,102,241,.13); border-color: rgba(99,102,241,.3); color: #a5b4fc; }

        /* Message rows */
        .msg-row { display: flex; align-items: flex-start; gap: 12px; }
        .msg-row.is-user { flex-direction: row-reverse; }

        .avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            flex-shrink: 0; margin-top: 2px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800;
        }
        .avatar-ai { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; }
        .avatar-user { background: rgba(148,163,184,.1); color: #64748b; font-size: 11px; }

        .bubble {
            max-width: 76%;
            padding: 14px 18px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.65;
        }
        .bubble-user {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border-bottom-right-radius: 5px;
            box-shadow: 0 4px 16px rgba(79,70,229,.25);
        }
        .bubble-ai {
            background: #111827;
            border: 1px solid rgba(148,163,184,.08);
            color: #cbd5e1;
            border-bottom-left-radius: 5px;
        }

        /* Confirmation */
        .confirm-banner {
            background: rgba(251,191,36,.06);
            border: 1px solid rgba(251,191,36,.2);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            color: #fde68a;
            line-height: 1.65;
        }

        /* Typing */
        .typing-wrap {
            display: flex; align-items: flex-start; gap: 12px;
        }
        .typing-dots {
            background: #111827;
            border: 1px solid rgba(148,163,184,.08);
            border-radius: 18px;
            border-bottom-left-radius: 5px;
            padding: 16px 20px;
            display: flex; gap: 5px; align-items: center;
        }
        .dot {
            width: 6px; height: 6px;
            background: #334155; border-radius: 50%;
            animation: bounce 1.4s infinite;
        }
        .dot:nth-child(2) { animation-delay: .2s; }
        .dot:nth-child(3) { animation-delay: .4s; }
        @keyframes bounce {
            0%,80%,100% { transform: translateY(0); opacity:.4; }
            40% { transform: translateY(-5px); opacity:1; }
        }

        /* Data table */
        .table-block {
            margin-top: 16px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(148,163,184,.09);
        }
        .table-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 9px 14px;
            background: rgba(99,102,241,.07);
            border-bottom: 1px solid rgba(148,163,184,.08);
        }
        .table-label { font-size: 11px; font-weight: 700; color: #818cf8; text-transform: uppercase; letter-spacing: .06em; }
        .table-count { font-size: 11px; color: #475569; font-weight: 600; }
        .table-scroll { overflow-x: auto; max-height: 320px; overflow-y: auto; }
        .table-scroll::-webkit-scrollbar { height: 3px; width: 3px; }
        .table-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,.15); border-radius: 4px; }

        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th {
            padding: 9px 13px;
            text-align: left; white-space: nowrap;
            font-weight: 700; font-size: 11px;
            color: #64748b;
            background: rgba(8,14,26,.7);
            border-bottom: 1px solid rgba(148,163,184,.07);
            letter-spacing: .03em; text-transform: uppercase;
            position: sticky; top: 0;
        }
        td {
            padding: 8px 13px;
            color: #94a3b8;
            border-bottom: 1px solid rgba(148,163,184,.04);
            white-space: nowrap;
            font-size: 12.5px;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) td { background: rgba(148,163,184,.02); }
        tr:hover td { background: rgba(99,102,241,.04); }

        /* Insight */
        .insight { color: #cbd5e1; }
        .insight strong { color: #e2e8f0; font-weight: 700; }

        /* Input */
        .input-area {
            padding: 14px 28px 28px;
            flex-shrink: 0;
        }
        .input-box {
            display: flex; align-items: flex-end; gap: 10px;
            background: #111827;
            border: 1px solid rgba(148,163,184,.1);
            border-radius: 18px;
            padding: 12px 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-box:focus-within {
            border-color: rgba(99,102,241,.35);
            box-shadow: 0 0 0 3px rgba(99,102,241,.08);
        }

        #msgInput {
            flex: 1;
            background: transparent;
            border: none; outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; font-weight: 500;
            color: #f1f5f9;
            resize: none;
            min-height: 22px; max-height: 140px;
            line-height: 1.6;
        }
        #msgInput::placeholder { color: #334155; }

        .btn-send {
            width: 38px; height: 38px; flex-shrink: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(99,102,241,.3);
            transition: opacity .2s, transform .1s;
        }
        .btn-send:hover { opacity: .88; }
        .btn-send:active { transform: scale(.96); }
        .btn-send:disabled { opacity: .35; cursor: not-allowed; transform: none; }

        .input-hint { font-size: 11.5px; color: #1e293b; text-align: center; margin-top: 10px; font-weight: 500; }
        .input-hint span { color: #334155; }
    </style>
</head>
<body>

{{-- ══════════════════════════════ LOGIN SCREEN ══════════════════════════════ --}}
@guest
<div class="login-wrap">
    <div class="login-card">
        <div class="brand-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/>
                <path d="M2 17l10 5 10-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12l10 5 10-5" stroke="rgba(255,255,255,.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1 class="login-title">AI Copilot</h1>
        <p class="login-subtitle">Masuk untuk mengakses ERP Assistant</p>

        @if ($errors->any())
            <div class="alert-error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="flex-shrink:0;margin-top:1px">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input class="form-input" type="email" id="email" name="email"
                    value="{{ old('email') }}" placeholder="nama@perusahaan.com" required autofocus autocomplete="email">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password"
                    placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</div>
@endguest

{{-- ══════════════════════════════ CHAT SCREEN ══════════════════════════════ --}}
@auth
<div class="chat-layout">

    {{-- Header --}}
    <header class="chat-header">
        <div class="header-brand">
            <div class="header-icon">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="#fff" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M2 17l10 5 10-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12l10 5 10-5" stroke="rgba(255,255,255,.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="header-name">AI Copilot</div>
                <div class="header-sub">ERP Production Tracking</div>
            </div>
        </div>

        <div class="header-right">
            <span class="header-user">{{ auth()->user()->name }}</span>
            <form method="POST" action="/logout" style="margin:0">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- Messages --}}
    <div class="messages-wrap" id="msgWrap">

        <div class="welcome" id="welcomeEl">
            <div class="welcome-icon-wrap">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" stroke="#818cf8" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M2 17l10 5 10-5" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12l10 5 10-5" stroke="rgba(129,140,248,.5)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="welcome-heading">Halo, {{ auth()->user()->name }}!</h2>
            <p class="welcome-desc">Tanyakan apa saja tentang data produksi ERP Anda. AI akan menganalisis dan memberikan insight secara real-time.</p>
            <div class="suggestions">
                <button class="chip" onclick="useSuggestion(this)">Status ASSY Semarang hari ini</button>
                <button class="chip" onclick="useSuggestion(this)">Total PACKING Surabaya bulan ini</button>
                <button class="chip" onclick="useSuggestion(this)">Data PAINTING terbaru di SMG</button>
                <button class="chip" onclick="useSuggestion(this)">Rekap BLEACHING SBY minggu ini</button>
            </div>
        </div>

    </div>

    {{-- Input --}}
    <div class="input-area">
        <div class="input-box">
            <textarea id="msgInput" rows="1"
                placeholder="Tanya tentang data produksi..."
                onkeydown="handleKey(event)"
                oninput="resize(this)"></textarea>
            <button class="btn-send" id="sendBtn" onclick="send()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </div>
        <p class="input-hint"><span>Enter</span> untuk kirim &nbsp;·&nbsp; <span>Shift+Enter</span> untuk baris baru</p>
    </div>

</div>

<script>
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const wrap   = document.getElementById('msgWrap');
const input  = document.getElementById('msgInput');
const btn    = document.getElementById('sendBtn');
let loading  = false;

function resize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 140) + 'px';
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
}

function useSuggestion(el) {
    input.value = el.textContent;
    resize(input);
    send();
}

function scrollEnd() { wrap.scrollTop = wrap.scrollHeight; }

function initials() {
    return @json(auth()->user()->name).split(' ').map(n => n[0]).join('').toUpperCase().slice(0,2);
}

function esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function fmtInsight(text) {
    return esc(text)
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\n/g, '<br>');
}

function buildTable(data) {
    if (!data || !data.length) return '';
    const keys = Object.keys(data[0]);
    const rows = data.map(r =>
        `<tr>${keys.map(k => `<td>${r[k] != null ? esc(String(r[k])) : '<span style="color:#1e293b">—</span>'}</td>`).join('')}</tr>`
    ).join('');
    return `
        <div class="table-block">
            <div class="table-bar">
                <span class="table-label">Hasil Data</span>
                <span class="table-count">${data.length} baris</span>
            </div>
            <div class="table-scroll">
                <table>
                    <thead><tr>${keys.map(k => `<th>${esc(k)}</th>`).join('')}</tr></thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
        </div>`;
}

function addMsg(role, html) {
    document.getElementById('welcomeEl')?.remove();

    const row = document.createElement('div');
    row.className = 'msg-row' + (role === 'user' ? ' is-user' : '');

    if (role === 'user') {
        row.innerHTML = `
            <div class="avatar avatar-user">${initials()}</div>
            <div class="bubble bubble-user">${html}</div>`;
    } else {
        row.innerHTML = `
            <div class="avatar avatar-ai">AI</div>
            <div class="bubble bubble-ai">${html}</div>`;
    }

    wrap.appendChild(row);
    scrollEnd();
}

function showTyping() {
    const el = document.createElement('div');
    el.className = 'typing-wrap';
    el.id = 'typing';
    el.innerHTML = `
        <div class="avatar avatar-ai">AI</div>
        <div class="typing-dots">
            <div class="dot"></div><div class="dot"></div><div class="dot"></div>
        </div>`;
    wrap.appendChild(el);
    scrollEnd();
}

function hideTyping() { document.getElementById('typing')?.remove(); }

async function send() {
    const msg = input.value.trim();
    if (!msg || loading) return;

    loading = true;
    btn.disabled = true;
    input.value = '';
    input.style.height = 'auto';

    addMsg('user', esc(msg));
    showTyping();

    try {
        const res  = await fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: msg }),
        });

        const json = await res.json();
        hideTyping();

        if (json.status === 'need_confirmation') {
            addMsg('ai', `<div class="confirm-banner"><strong>⚠ Perlu Konfirmasi</strong><br><br>${fmtInsight(json.message)}</div>`);

        } else if (json.error) {
            addMsg('ai', `<span style="color:#fca5a5">${esc(json.message || json.error)}</span>`);

        } else {
            let content = '';
            if (json.insight) content += `<div class="insight">${fmtInsight(json.insight)}</div>`;
            if (json.data && json.data.length) content += buildTable(json.data);
            if (!content) content = '<span style="color:#334155">Tidak ada data yang ditemukan.</span>';
            addMsg('ai', content);
        }

    } catch {
        hideTyping();
        addMsg('ai', '<span style="color:#fca5a5">Gagal terhubung ke server. Silakan coba lagi.</span>');
    }

    loading = false;
    btn.disabled = false;
    input.focus();
}
</script>
@endauth

</body>
</html>
