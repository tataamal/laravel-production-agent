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
            background: #f0fdf4;
            color: #111827;
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
            background: #ffffff;
            border: 1px solid #bbf7d0;
            border-radius: 24px;
            padding: 40px 40px 44px;
            box-shadow: 0 20px 60px rgba(22,163,74,.1), 0 4px 16px rgba(0,0,0,.06);
        }

        .brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #22c55e, #15803d);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            box-shadow: 0 8px 24px rgba(22,163,74,.3);
        }

        .login-title { font-size: 26px; font-weight: 800; letter-spacing: -.5px; margin-bottom: 6px; color: #111827; }
        .login-subtitle { font-size: 14px; color: #6b7280; font-weight: 500; margin-bottom: 36px; }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13px; font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
            letter-spacing: .01em;
        }

        .form-input {
            width: 100%;
            background: #f9fafb;
            border: 1.5px solid #d1fae5;
            border-radius: 12px;
            padding: 13px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: #111827;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34,197,94,.12);
            background: #fff;
        }
        .form-input::placeholder { color: #9ca3af; }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #15803d);
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
            box-shadow: 0 4px 20px rgba(22,163,74,.3);
        }
        .btn-login:hover { opacity: .9; }
        .btn-login:active { transform: scale(.99); }

        .alert-error {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 8px;
        }

        /* ── CHAT LAYOUT ── */
        .chat-layout {
            display: flex; flex-direction: column;
            height: 100vh; width: 100%;
            max-width: 980px;
        }

        .chat-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 28px;
            border-bottom: 1.5px solid #dcfce7;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(12px);
            flex-shrink: 0;
            box-shadow: 0 1px 8px rgba(22,163,74,.07);
        }

        .header-brand { display: flex; align-items: center; gap: 12px; }

        .header-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #22c55e, #15803d);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(22,163,74,.3);
            flex-shrink: 0;
            color: #fff;
        }

        .header-name { font-size: 16px; font-weight: 800; letter-spacing: -.3px; color: #111827; }
        .header-sub { font-size: 11.5px; color: #16a34a; font-weight: 600; margin-top: 1px; }

        .header-right { display: flex; align-items: center; gap: 10px; }
        .header-user {
            font-size: 13px; color: #6b7280; font-weight: 500;
            padding: 5px 10px;
            background: #f0fdf4;
            border-radius: 20px;
            border: 1px solid #bbf7d0;
        }

        .btn-clear {
            display: flex; align-items: center; gap: 6px;
            background: #fff;
            border: 1.5px solid #bbf7d0;
            border-radius: 9px;
            padding: 7px 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 600;
            color: #16a34a;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-clear:hover { background: #f0fdf4; border-color: #86efac; }

        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 9px;
            padding: 7px 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px; font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-logout:hover { background: #f9fafb; border-color: #d1d5db; color: #374151; }

        /* ── MESSAGES ── */
        .messages-wrap {
            flex: 1;
            overflow-y: auto;
            padding: 28px 28px 8px;
            display: flex; flex-direction: column;
            gap: 20px;
            background: #f8fffe;
        }
        .messages-wrap::-webkit-scrollbar { width: 4px; }
        .messages-wrap::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 4px; }

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
            width: 76px; height: 76px;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border: 2px solid #86efac;
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(22,163,74,.15);
            color: #16a34a;
        }
        .welcome-heading { font-size: 24px; font-weight: 800; letter-spacing: -.4px; margin-bottom: 10px; color: #111827; }
        .welcome-desc { font-size: 14px; color: #6b7280; line-height: 1.7; max-width: 380px; font-weight: 500; }

        .suggestions { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; margin-top: 28px; }
        .chip {
            background: #fff;
            border: 1.5px solid #bbf7d0;
            border-radius: 100px;
            padding: 9px 18px;
            font-size: 13px; font-weight: 600;
            color: #15803d;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s;
            box-shadow: 0 1px 4px rgba(22,163,74,.08);
        }
        .chip:hover { background: #f0fdf4; border-color: #86efac; color: #16a34a; box-shadow: 0 2px 8px rgba(22,163,74,.15); }

        /* Message rows */
        .msg-row { display: flex; align-items: flex-start; gap: 12px; }
        .msg-row.is-user { flex-direction: row-reverse; }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 11px;
            flex-shrink: 0; margin-top: 2px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800;
        }
        .avatar-ai {
            background: linear-gradient(135deg, #22c55e, #15803d);
            color: #fff;
            box-shadow: 0 3px 10px rgba(22,163,74,.3);
        }
        .avatar-user {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 11px;
            border: 1.5px solid #bae6fd;
        }

        .bubble {
            max-width: 76%;
            padding: 14px 18px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.65;
        }
        .bubble-user {
            background: linear-gradient(135deg, #16a34a, #166534);
            color: #fff;
            border-bottom-right-radius: 5px;
            box-shadow: 0 4px 16px rgba(22,163,74,.25);
        }
        .bubble-ai {
            background: #ffffff;
            border: 1.5px solid #d1fae5;
            color: #1f2937;
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 8px rgba(22,163,74,.07);
        }

        /* Confirmation */
        .confirm-banner {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            color: #92400e;
            line-height: 1.65;
        }

        /* Typing */
        .typing-wrap { display: flex; align-items: flex-start; gap: 12px; }
        .typing-dots {
            background: #fff;
            border: 1.5px solid #d1fae5;
            border-radius: 18px;
            border-bottom-left-radius: 5px;
            padding: 16px 20px;
            display: flex; gap: 5px; align-items: center;
            box-shadow: 0 2px 8px rgba(22,163,74,.07);
        }
        .dot {
            width: 6px; height: 6px;
            background: #86efac; border-radius: 50%;
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
            margin-top: 14px;
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid #d1fae5;
        }
        .table-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 9px 14px;
            background: #f0fdf4;
            border-bottom: 1.5px solid #d1fae5;
        }
        .table-label { font-size: 11px; font-weight: 700; color: #16a34a; text-transform: uppercase; letter-spacing: .06em; }
        .table-count { font-size: 11px; color: #6b7280; font-weight: 600; }
        .table-scroll { overflow-x: auto; max-height: 300px; overflow-y: auto; }
        .table-scroll::-webkit-scrollbar { height: 3px; width: 3px; }
        .table-scroll::-webkit-scrollbar-thumb { background: #bbf7d0; border-radius: 4px; }

        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th {
            padding: 9px 13px;
            text-align: left; white-space: nowrap;
            font-weight: 700; font-size: 11px;
            color: #374151;
            background: #f9fafb;
            border-bottom: 1.5px solid #e5e7eb;
            letter-spacing: .03em; text-transform: uppercase;
            position: sticky; top: 0;
        }
        td {
            padding: 8px 13px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
            font-size: 12.5px;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) td { background: #f9fafb; }
        tr:hover td { background: #f0fdf4; }

        /* Insight */
        .insight { color: #1f2937; }
        .insight strong { color: #111827; font-weight: 700; }

        /* Input */
        .input-area {
            padding: 14px 28px 28px;
            flex-shrink: 0;
            background: #fff;
            border-top: 1.5px solid #dcfce7;
        }
        .input-box {
            display: flex; align-items: flex-end; gap: 10px;
            background: #f9fafb;
            border: 1.5px solid #d1fae5;
            border-radius: 18px;
            padding: 12px 14px;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-box:focus-within {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34,197,94,.1);
            background: #fff;
        }

        #msgInput {
            flex: 1;
            background: transparent;
            border: none; outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; font-weight: 500;
            color: #111827;
            resize: none;
            min-height: 22px; max-height: 140px;
            line-height: 1.6;
        }
        #msgInput::placeholder { color: #9ca3af; }

        .btn-send {
            width: 38px; height: 38px; flex-shrink: 0;
            background: linear-gradient(135deg, #22c55e, #15803d);
            border: none; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(22,163,74,.3);
            transition: opacity .2s, transform .1s;
        }
        .btn-send:hover { opacity: .88; }
        .btn-send:active { transform: scale(.96); }
        .btn-send:disabled { opacity: .35; cursor: not-allowed; transform: none; }

        .input-hint { font-size: 11.5px; color: #9ca3af; text-align: center; margin-top: 8px; font-weight: 500; }
        .input-hint kbd {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 1px 5px;
            font-family: inherit;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════ LOGIN SCREEN ══════════════════════════════ --}}
@guest
<div class="login-wrap">
    <div class="login-card">
        <div class="brand-icon">
            {{-- Robot icon --}}
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                <rect x="4" y="7" width="16" height="11" rx="3" fill="white"/>
                <rect x="8.5" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
                <rect x="13" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
                <path d="M9 15.5h6" stroke="#22c55e" stroke-width="1.3" stroke-linecap="round"/>
                <line x1="12" y1="4" x2="12" y2="7" stroke="white" stroke-width="1.5"/>
                <circle cx="12" cy="3" r="1.3" fill="white"/>
                <rect x="2" y="10" width="2" height="4" rx="1" fill="white"/>
                <rect x="20" y="10" width="2" height="4" rx="1" fill="white"/>
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
                {{-- Robot icon --}}
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="7" width="16" height="11" rx="3" fill="white"/>
                    <rect x="8.5" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
                    <rect x="13" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
                    <path d="M9 15.5h6" stroke="#22c55e" stroke-width="1.3" stroke-linecap="round"/>
                    <line x1="12" y1="4" x2="12" y2="7" stroke="white" stroke-width="1.5"/>
                    <circle cx="12" cy="3" r="1.3" fill="white"/>
                    <rect x="2" y="10" width="2" height="4" rx="1" fill="white"/>
                    <rect x="20" y="10" width="2" height="4" rx="1" fill="white"/>
                </svg>
            </div>
            <div>
                <div class="header-name">AI Copilot</div>
                <div class="header-sub">ERP Production Tracking</div>
            </div>
        </div>

        <div class="header-right">
            <span class="header-user">{{ auth()->user()->name }}</span>

            {{-- Clear chat --}}
            <button class="btn-clear" onclick="clearChat()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                Hapus Chat
            </button>

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
                {{-- Large robot icon --}}
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="7" width="16" height="11" rx="3" fill="#16a34a"/>
                    <rect x="8.5" y="11" width="2.5" height="2.5" rx=".7" fill="white"/>
                    <rect x="13" y="11" width="2.5" height="2.5" rx=".7" fill="white"/>
                    <path d="M9 15.5h6" stroke="white" stroke-width="1.3" stroke-linecap="round"/>
                    <line x1="12" y1="4" x2="12" y2="7" stroke="#16a34a" stroke-width="1.5"/>
                    <circle cx="12" cy="3" r="1.3" fill="#16a34a"/>
                    <rect x="2" y="10" width="2" height="4" rx="1" fill="#16a34a"/>
                    <rect x="20" y="10" width="2" height="4" rx="1" fill="#16a34a"/>
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
        <p class="input-hint"><kbd>Enter</kbd> untuk kirim &nbsp;·&nbsp; <kbd>Shift+Enter</kbd> untuk baris baru</p>
    </div>

</div>

<script>
const CSRF  = document.querySelector('meta[name="csrf-token"]').content;
const wrap  = document.getElementById('msgWrap');
const input = document.getElementById('msgInput');
const btn   = document.getElementById('sendBtn');
let loading = false;

const ROBOT_AVATAR = `
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
        <rect x="4" y="7" width="16" height="11" rx="3" fill="white"/>
        <rect x="8.5" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
        <rect x="13" y="11" width="2.5" height="2.5" rx=".7" fill="#22c55e"/>
        <path d="M9 15.5h6" stroke="#22c55e" stroke-width="1.3" stroke-linecap="round"/>
        <line x1="12" y1="4" x2="12" y2="7" stroke="white" stroke-width="1.5"/>
        <circle cx="12" cy="3" r="1.3" fill="white"/>
        <rect x="2" y="10" width="2" height="4" rx="1" fill="white"/>
        <rect x="20" y="10" width="2" height="4" rx="1" fill="white"/>
    </svg>`;

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
    return @json(auth()->user()->name).split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
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
        `<tr>${keys.map(k => `<td>${r[k] != null ? esc(String(r[k])) : '<span style="color:#d1d5db">—</span>'}</td>`).join('')}</tr>`
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
            <div class="avatar avatar-ai">${ROBOT_AVATAR}</div>
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
        <div class="avatar avatar-ai">${ROBOT_AVATAR}</div>
        <div class="typing-dots">
            <div class="dot"></div><div class="dot"></div><div class="dot"></div>
        </div>`;
    wrap.appendChild(el);
    scrollEnd();
}

function hideTyping() { document.getElementById('typing')?.remove(); }

function clearChat() {
    wrap.innerHTML = '';
    const welcome = document.createElement('div');
    welcome.className = 'welcome';
    welcome.id = 'welcomeEl';
    welcome.innerHTML = `
        <div class="welcome-icon-wrap">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none">
                <rect x="4" y="7" width="16" height="11" rx="3" fill="#16a34a"/>
                <rect x="8.5" y="11" width="2.5" height="2.5" rx=".7" fill="white"/>
                <rect x="13" y="11" width="2.5" height="2.5" rx=".7" fill="white"/>
                <path d="M9 15.5h6" stroke="white" stroke-width="1.3" stroke-linecap="round"/>
                <line x1="12" y1="4" x2="12" y2="7" stroke="#16a34a" stroke-width="1.5"/>
                <circle cx="12" cy="3" r="1.3" fill="#16a34a"/>
                <rect x="2" y="10" width="2" height="4" rx="1" fill="#16a34a"/>
                <rect x="20" y="10" width="2" height="4" rx="1" fill="#16a34a"/>
            </svg>
        </div>
        <h2 class="welcome-heading">Chat dibersihkan!</h2>
        <p class="welcome-desc">Siap menerima pertanyaan baru. Tanyakan apa saja tentang data produksi ERP Anda.</p>
        <div class="suggestions">
            <button class="chip" onclick="useSuggestion(this)">Status ASSY Semarang hari ini</button>
            <button class="chip" onclick="useSuggestion(this)">Total PACKING Surabaya bulan ini</button>
            <button class="chip" onclick="useSuggestion(this)">Data PAINTING terbaru di SMG</button>
            <button class="chip" onclick="useSuggestion(this)">Rekap BLEACHING SBY minggu ini</button>
        </div>`;
    wrap.appendChild(welcome);
}

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
            let errHtml = `<div style="color:#dc2626;font-weight:600;margin-bottom:${json.detail ? '10px' : '0'}">${esc(json.message || json.error)}</div>`;
            if (json.detail) {
                errHtml += `<div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:8px;padding:10px 13px;font-size:12px;color:#b91c1c;font-family:monospace;line-height:1.6;word-break:break-word">${esc(json.detail)}</div>`;
            }
            addMsg('ai', errHtml);

        } else {
            let content = '';
            if (json.insight) content += `<div class="insight">${fmtInsight(json.insight)}</div>`;
            if (json.data && json.data.length) content += buildTable(json.data);
            if (!content) content = '<span style="color:#9ca3af">Tidak ada data yang ditemukan.</span>';
            addMsg('ai', content);
        }

    } catch {
        hideTyping();
        addMsg('ai', '<span style="color:#dc2626">Gagal terhubung ke server. Silakan coba lagi.</span>');
    }

    loading = false;
    btn.disabled = false;
    input.focus();
}
</script>
@endauth

</body>
</html>
