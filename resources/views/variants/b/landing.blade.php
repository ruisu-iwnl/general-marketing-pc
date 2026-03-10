<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="영어공부, 영어회화, 영어실력 향상, 영어학습 방법, 영어챌린지, 매일영 챌린지, 매일영챌린지, 매일영첼린지, 매일영 첼린지, Maeil English Challenge, 영어 실력 향상의 현실적인 방법, 한 달 만에 영어 가능할까, 과장 없는 영어 학습 프로그램, 영어 공부 기대와 현실, 꾸준함으로 영어 실력 올리는 법, 실전 중심 영어 학습법">
    <meta name="description" content="영어 공부, 또 작심삼일? 혼자 하면 100% 포기합니다. 전담 강사가 매일 당신의 입을 열게 만드는 강제 스피킹 루틴, 매일영 챌린지.">
    <title>매일영 챌린지 — 강제 스피킹 루틴</title>

    <!-- OpenGraph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="매일영 챌린지">
    <meta property="og:locale" content="ko_KR">
    <meta property="og:title" content="의지는 필요 없습니다. 입이 트이는 영어 강제 루틴, 매일영 챌린지">
    <meta property="og:description" content="혼자 하면 100% 포기합니다. 전담 강사가 매일 당신의 입을 열게 만드는 강제 스피킹 루틴.">
    <meta property="og:image" content="{{ asset('landing/thumbnail.jpg') }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="400">
    <meta property="og:image:alt" content="매일영 챌린지 대표 이미지">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="의지는 필요 없습니다. 입이 트이는 영어 강제 루틴, 매일영 챌린지">
    <meta name="twitter:description" content="혼자 하면 100% 포기합니다. 전담 강사가 매일 당신의 입을 열게 만드는 강제 스피킹 루틴.">
    <meta name="twitter:image" content="{{ asset('landing/thumbnail.jpg') }}">
    <meta name="twitter:image:alt" content="매일영 챌린지 대표 이미지">

    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#112747">
    <meta name="apple-mobile-web-app-title" content="매일영 챌린지">
    <meta name="application-name" content="매일영 챌린지">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('landing/Image20260107150048.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('landing/Image20260107150048.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream1.otf') }}') format('opentype');
            font-weight: 100;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream3.otf') }}') format('opentype');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream4.otf') }}') format('opentype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream5.otf') }}') format('opentype');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream6.otf') }}') format('opentype');
            font-weight: 600;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream7.otf') }}') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream8.otf') }}') format('opentype');
            font-weight: 800;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'TheSCoD';
            src: url('{{ asset('landing/fonts/SCDream9.otf') }}') format('opentype');
            font-weight: 900;
            font-style: normal;
            font-display: swap;
        }

        /* ===== 리셋 & 기본 ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
            font-weight: 400;
            font-size: 16px;
            color: #1a1a1a;
            background-color: #ffffff;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== 상단 띠배너 ===== */
        .top-banner {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 10px 16px;
            text-align: center;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .top-banner .live-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .top-banner .divider {
            width: 1px;
            height: 14px;
            background: rgba(255,255,255,0.4);
            display: inline-block;
            margin: 0 4px;
        }

        .top-banner .seats {
            color: #fde68a;
            font-weight: 700;
        }

        /* ===== 히어로 섹션 ===== */
        .hero {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            padding: 48px 20px 40px;
            text-align: center;
            color: #fff;
        }

        .hero .badge-text {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 400;
            color: #94a3b8;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.4;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .hero h1 .highlight {
            color: #f87171;
        }

        .hero .sub {
            font-size: 16px;
            font-weight: 300;
            line-height: 1.7;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .hero .social-proof {
            font-size: 14px;
            color: #fbbf24;
            font-weight: 600;
            margin-bottom: 28px;
        }

        .hero-cta {
            display: block;
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            padding: 18px 24px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s;
        }

        .hero-cta:hover { background: #dc2626; color: #fff; }

        .hero .micro-text {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 12px;
        }

        /* ===== 공통 섹션 ===== */
        .section {
            padding: 48px 20px;
        }

        .section-white { background: #ffffff; }
        .section-gray { background: #f8fafc; }
        .section-dark { background: #0f172a; color: #fff; }

        .section-inner {
            max-width: 480px;
            margin: 0 auto;
        }

        .section h2 {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.4;
            margin-bottom: 16px;
            letter-spacing: -0.3px;
        }

        .section p {
            font-size: 15px;
            font-weight: 300;
            line-height: 1.7;
            margin-bottom: 12px;
            color: #475569;
        }

        .section-dark p { color: #cbd5e1; }

        /* ===== 고통 체크리스트 ===== */
        .pain-list {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }

        .pain-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            margin-bottom: 8px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 400;
            line-height: 1.5;
            color: #334155;
        }

        .pain-list li .check-icon {
            width: 22px;
            height: 22px;
            min-width: 22px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            margin-top: 1px;
        }

        .pain-resolve {
            text-align: center;
            padding: 20px 0 0;
        }

        .pain-resolve p {
            font-size: 16px;
            font-weight: 500;
            color: #1e293b;
        }

        .pain-resolve .emphasis {
            color: #ef4444;
            font-weight: 700;
        }

        /* ===== 3단계 카드 ===== */
        .step-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            margin-bottom: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .step-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 20px 16px;
        }

        .step-icon-wrap {
            width: 72px;
            height: 72px;
            min-width: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .step-card:nth-child(1) .step-icon-wrap { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); }
        .step-card:nth-child(2) .step-icon-wrap { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); }
        .step-card:nth-child(3) .step-icon-wrap { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); }

        .step-icon-wrap img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .step-label .step-number {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4px;
        }

        .step-card:nth-child(1) .step-number { color: #ef4444; }
        .step-card:nth-child(2) .step-number { color: #f59e0b; }
        .step-card:nth-child(3) .step-number { color: #10b981; }

        .step-label h3 {
            font-size: 20px;
            font-weight: 800;
            line-height: 1.3;
            color: #0f172a;
            margin: 0;
        }

        .step-body {
            padding: 0 20px 20px;
        }

        .step-body p {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.7;
            color: #475569;
            margin: 0 0 12px;
        }

        .step-card .force-tag {
            display: inline-block;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 50px;
            letter-spacing: 0.3px;
        }

        .step-card:nth-child(1) .force-tag { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .step-card:nth-child(2) .force-tag { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .step-card:nth-child(3) .force-tag { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }

        .step-bottom-text {
            text-align: center;
            margin-top: 24px;
            padding: 20px;
            background: #0f172a;
            border-radius: 12px;
            color: #fff;
        }

        .step-bottom-text p {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0;
            line-height: 1.6;
        }

        .step-bottom-text .accent {
            color: #fbbf24;
        }

        /* ===== 사회적 증거 ===== */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .stat-item {
            text-align: center;
            padding: 16px 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 800;
            color: #fbbf24;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 400;
            color: #94a3b8;
            margin-top: 4px;
            display: block;
        }

        .review-card-b {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 12px;
        }

        .review-stars {
            color: #fbbf24;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .review-text {
            font-size: 14px;
            font-weight: 300;
            line-height: 1.7;
            color: #e2e8f0;
            margin-bottom: 10px;
        }

        .review-author-b {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 400;
        }

        /* ===== 리드 폼 ===== */
        .form-section {
            padding: 48px 20px;
            background: #ffffff;
        }

        .form-inner {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-inner h2 {
            font-size: 22px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .form-inner .form-subtitle {
            font-size: 14px;
            color: #64748b;
            text-align: center;
            margin-bottom: 24px;
            font-weight: 300;
        }

        .form-inner label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-inner input[type="text"],
        .form-inner input[type="tel"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
            margin-bottom: 14px;
            transition: border-color 0.2s;
            background: #f8fafc;
        }

        .form-inner input:focus {
            outline: none;
            border-color: #ef4444;
            background: #fff;
        }

        .form-inner .privacy-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 13px;
            color: #64748b;
        }

        .form-inner .privacy-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ef4444;
        }

        .form-inner .privacy-check a {
            color: #ef4444;
            text-decoration: underline;
        }

        .form-submit-btn {
            width: 100%;
            padding: 18px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .form-submit-btn:hover { background: #dc2626; }
        .form-submit-btn:disabled { background: #cbd5e1; cursor: not-allowed; }

        .error-msg {
            color: #ef4444;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
            display: none;
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: #64748b;
            font-weight: 400;
        }

        .trust-badge .badge-icon {
            color: #10b981;
            font-size: 14px;
        }

        /* ===== 카운트다운 ===== */
        .countdown-wrap {
            text-align: center;
            margin-top: 24px;
            padding: 20px;
            background: #fef2f2;
            border-radius: 12px;
            border: 1px solid #fecaca;
        }

        .countdown-label {
            font-size: 13px;
            color: #991b1b;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .countdown-unit {
            background: #dc2626;
            color: #fff;
            border-radius: 8px;
            padding: 8px 12px;
            min-width: 50px;
            text-align: center;
        }

        .countdown-num {
            font-size: 22px;
            font-weight: 800;
            display: block;
            line-height: 1;
        }

        .countdown-txt {
            font-size: 10px;
            font-weight: 400;
            margin-top: 4px;
            display: block;
            opacity: 0.8;
        }

        .fomo-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #64748b;
            font-weight: 400;
            line-height: 1.6;
        }

        .fomo-text strong {
            color: #1e293b;
            font-weight: 700;
        }

        /* ===== 상세 정보 아코디언 ===== */
        .info-section h2 {
            text-align: center;
        }

        .accordion-item {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 10px;
            overflow: hidden;
            background: #fff;
        }

        .accordion-header {
            padding: 16px 20px;
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .accordion-header .arrow {
            transition: transform 0.2s;
            font-size: 12px;
            color: #94a3b8;
        }

        .accordion-header.active .arrow {
            transform: rotate(180deg);
        }

        .accordion-body {
            padding: 0 20px 16px;
            font-size: 14px;
            font-weight: 300;
            line-height: 1.7;
            color: #475569;
            display: none;
        }

        .accordion-body.show { display: block; }

        .accordion-body ul {
            list-style: none;
            padding: 0;
            margin: 8px 0;
        }

        .accordion-body ul li {
            padding-left: 16px;
            position: relative;
            margin-bottom: 4px;
        }

        .accordion-body ul li::before {
            content: '·';
            position: absolute;
            left: 0;
            font-weight: 700;
        }

        /* ===== 영상 ===== */
        .video-wrapper-b {
            max-width: 480px;
            margin: 0 auto;
            aspect-ratio: 16 / 9;
            border-radius: 12px;
            overflow: hidden;
        }

        .video-wrapper-b iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* ===== 카카오 문의 ===== */
        .kakao-section {
            text-align: center;
            padding: 40px 20px;
            background: #f8fafc;
        }

        .kakao-section h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .kakao-section p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
        }

        .kakao-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #FEE500;
            color: #000;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .kakao-btn:hover { background: #FDD835; color: #000; }
        .kakao-btn img { width: 22px; height: 22px; }

        /* ===== 푸터 ===== */
        .footer-b {
            background: #1e293b;
            padding: 32px 20px;
            text-align: center;
            color: #94a3b8;
        }

        .footer-logo-b {
            font-size: 14px;
            font-weight: 300;
            margin-bottom: 16px;
        }

        .footer-social-b {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .footer-social-b a {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-social-b a:hover { background: rgba(255,255,255,0.2); }
        .footer-social-b img { width: 16px; height: 16px; }

        .footer-nav-b {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px 16px;
            margin-bottom: 16px;
        }

        .footer-nav-b a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 12px;
            font-weight: 300;
        }

        .footer-nav-b a:hover { color: #e2e8f0; }

        .footer-info-b {
            font-size: 10px;
            line-height: 1.7;
            color: #64748b;
        }

        .footer-info-b p { margin: 0 0 2px; }

        /* ===== 플로팅 CTA ===== */
        .floating-cta {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 12px 16px;
            padding-bottom: max(12px, env(safe-area-inset-bottom));
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid #e2e8f0;
            display: none;
        }

        .floating-cta.show { display: block; }

        .floating-cta-btn {
            display: block;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            padding: 16px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 700;
            font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .floating-cta-btn:hover { background: #dc2626; color: #fff; }

        /* ===== 실시간 토스트 ===== */
        .toast-notification {
            position: fixed;
            bottom: 80px;
            left: 16px;
            right: 16px;
            max-width: 360px;
            z-index: 90;
            background: #fff;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            border-left: 4px solid #10b981;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #334155;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .toast-notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            flex-shrink: 0;
        }


        /* ===== 개인정보 모달 ===== */
        .privacy-overlay {
            position: fixed;
            inset: 0;
            z-index: 150;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .privacy-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .privacy-modal-b {
            background: #fff;
            border-radius: 16px;
            max-width: 480px;
            width: 100%;
            max-height: 80vh;
            overflow: hidden;
        }

        .privacy-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .privacy-modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: #111;
        }

        .privacy-modal-header button {
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
        }

        .privacy-modal-body {
            padding: 20px;
            overflow-y: auto;
            max-height: 60vh;
            font-size: 13px;
            color: #666;
            line-height: 1.7;
        }

        .privacy-modal-body strong { color: #111; }

        .privacy-modal-footer {
            padding: 12px 20px;
            border-top: 1px solid #f0f0f0;
        }

        .privacy-modal-footer button {
            width: 100%;
            padding: 12px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ===== 커리큘럼 카드 ===== */
        .curriculum-week {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px 20px;
            margin-bottom: 14px;
            position: relative;
            overflow: hidden;
        }

        .curriculum-week::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .curriculum-week:nth-child(1)::before { background: #ef4444; }
        .curriculum-week:nth-child(2)::before { background: #f59e0b; }
        .curriculum-week:nth-child(3)::before { background: #3b82f6; }
        .curriculum-week:nth-child(4)::before { background: #10b981; }

        .curriculum-week .week-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .curriculum-week:nth-child(1) .week-badge { color: #ef4444; }
        .curriculum-week:nth-child(2) .week-badge { color: #f59e0b; }
        .curriculum-week:nth-child(3) .week-badge { color: #3b82f6; }
        .curriculum-week:nth-child(4) .week-badge { color: #10b981; }

        .curriculum-week h3 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 12px;
        }

        .curriculum-list {
            list-style: none;
            padding: 0;
            margin: 0 0 12px;
        }

        .curriculum-list li {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.6;
            color: #475569;
            padding: 4px 0 4px 20px;
            position: relative;
        }

        .curriculum-list li::before {
            content: '\25B8';
            position: absolute;
            left: 0;
            color: #94a3b8;
        }

        .curriculum-result {
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 50px;
        }

        .curriculum-week:nth-child(1) .curriculum-result { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .curriculum-week:nth-child(2) .curriculum-result { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .curriculum-week:nth-child(3) .curriculum-result { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .curriculum-week:nth-child(4) .curriculum-result { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }

        /* ===== 리뷰 이니셜 아바타 ===== */
        .review-avatar-initial {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        /* ===== B Variant 이미지 스타일 ===== */
        .hero-image {
            width: 100%;
            max-width: 400px;
            border-radius: 16px;
            margin: 20px auto 24px;
            display: block;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .pain-image {
            width: 100%;
            max-width: 320px;
            border-radius: 12px;
            margin: 0 auto 20px;
            display: block;
            opacity: 0.9;
        }


        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .review-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.15);
            flex-shrink: 0;
        }

        .review-meta {
            display: flex;
            flex-direction: column;
        }

        .review-meta .review-author-b {
            margin: 0;
        }

        .trust-badge-img {
            width: 100%;
            max-width: 360px;
            margin: 20px auto 0;
            display: block;
            border-radius: 8px;
        }

        .kakao-image {
            width: 120px;
            height: auto;
            margin: 0 auto 16px;
            display: block;
        }

        /* ===== 고정 헤더 ===== */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 110;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .site-header .header-logo {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .site-header .header-text {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }

        .site-header .header-text span {
            font-size: 11px;
            font-weight: 400;
            color: #94a3b8;
        }

        /* ===== body padding for header + floating CTA ===== */
        body { padding-top: 52px; padding-bottom: 72px; }

        /* ===== 480px 이하 미세 조정 ===== */
        @media (max-width: 480px) {
            .hero { padding: 36px 16px 32px; }
            .hero h1 { font-size: 24px; }
            .section { padding: 40px 16px; }
            .section h2 { font-size: 20px; }
            .stat-number { font-size: 18px; }
            .countdown-num { font-size: 18px; }
            .countdown-unit { padding: 6px 8px; min-width: 42px; }
        }
    </style>
</head>
<body>

    {{-- ===== 고정 헤더 ===== --}}
    <header class="site-header">
        <img src="{{ asset('landing/Image20260107150048.png') }}" alt="P" class="header-logo">
        <div class="header-text">매일영챌린지 <span>by 파워잉글리쉬</span></div>
    </header>

    {{-- ===== 상단 띠배너 ===== --}}
    <div class="top-banner">
        <span class="live-dot"></span>
        <span>지금 <strong id="live-viewers"></strong>명이 보고 있습니다</span>
        <span class="divider"></span>
        <span>무료체험 잔여 <span class="seats" id="remaining-seats">12</span>석</span>
    </div>

    {{-- ===== 히어로 ===== --}}
    <section class="hero">
        <div class="section-inner">
            <div class="badge-text">1:1 전담 강사 매일 관리 프로그램</div>
            <h1>영어 공부,<br><span class="highlight">또 작심삼일</span>이죠?</h1>
            <p class="sub">혼자 하면 결국 포기합니다. 누구나 그랬습니다.<br>그래서 강사가 매일 당신을 잡습니다.</p>
            <p class="social-proof">12,849명이 이미 시작한 강제 스피킹 루틴</p>
            <img src="{{ asset('landing/b/hero-main.jpg') }}" alt="매일영 챌린지 수강생" class="hero-image" loading="eager">
            <a href="https://www.pweng.net/level-test.php" class="hero-cta level-test-link" target="_blank">무료로 내 영어실력 확인하기</a>
            <p class="micro-text">100% 무료 · 강제 결제 없음 · 30초면 완료</p>
        </div>
    </section>

    {{-- ===== 고통 증폭 (Agitation) ===== --}}
    <section class="section section-gray">
        <div class="section-inner">
            <img src="{{ asset('landing/b/pain-agitation.jpg') }}" alt="영어 공부 좌절" class="pain-image" loading="lazy">
            <h2>혹시 이런 경험 있으신가요?</h2>
            <ul class="pain-list">
                <li>
                    <span class="check-icon">&#10003;</span>
                    <div>영어 학원 등록하고 3개월 안에 포기한 적 있다<br><small style="color:#ef4444; font-weight:500;">그 수강료는 그냥 날아갔습니다</small></div>
                </li>
                <li>
                    <span class="check-icon">&#10003;</span>
                    <div>인강 결제만 하고 1주일 만에 안 본 적 있다<br><small style="color:#ef4444; font-weight:500;">결제 내역만 남았습니다</small></div>
                </li>
                <li>
                    <span class="check-icon">&#10003;</span>
                    <div>"이번엔 진짜" 했는데 또 작심삼일이었다<br><small style="color:#ef4444; font-weight:500;">그리고 또 1년이 지났습니다</small></div>
                </li>
                <li>
                    <span class="check-icon">&#10003;</span>
                    <div>영어 못하는 게 부끄러워서 말을 꺼내기 싫다<br><small style="color:#ef4444; font-weight:500;">해외여행에서도, 회의에서도, 계속 움츠러들고 있습니다</small></div>
                </li>
            </ul>
            <img src="{{ asset('landing/b/before-after.jpg') }}" alt="Before & After" style="width:100%; max-width:480px; border-radius:12px; margin:20px auto 20px; display:block;" loading="lazy">
            <div class="pain-resolve">
                <p>전부 해당되시죠?<br><span class="emphasis">당신 잘못이 아닙니다.</span> 방법이 틀렸을 뿐이에요.<br><strong style="color:#0f172a; font-size:17px;">하지만 이대로 또 1년을 보내실 건가요?</strong></p>
            </div>
        </div>
    </section>

    {{-- ===== 3단계 강제 루틴 ===== --}}
    <section class="section section-white">
        <div class="section-inner">
            <h2>그래서 의지력을 빼버렸습니다</h2>
            <p style="color:#64748b; margin-bottom:24px;">"안 할 수가 없는" 3단계 강제 루틴</p>

            <div class="step-card">
                <div class="step-header">
                    <div class="step-icon-wrap">
                        <img src="{{ asset('landing/b/step-icon-1.jpg') }}" alt="녹음 인증" loading="lazy">
                    </div>
                    <div class="step-label">
                        <div class="step-number">STEP 1</div>
                        <h3>녹음 인증</h3>
                    </div>
                </div>
                <div class="step-body">
                    <p>매일 수업 전, 핵심 문장을 직접 소리 내어 녹음합니다. <strong style="color:#0f172a;">제출하지 않으면 그날 수업 자체가 잠깁니다.</strong> 변명도, 미루기도 통하지 않는 구조입니다.</p>
                    <span class="force-tag">도망칠 수 없습니다</span>
                </div>
            </div>

            <div class="step-card">
                <div class="step-header">
                    <div class="step-icon-wrap">
                        <img src="{{ asset('landing/b/step-icon-2.jpg') }}" alt="외워 뱉기" loading="lazy">
                    </div>
                    <div class="step-label">
                        <div class="step-number">STEP 2</div>
                        <h3>외워 뱉기</h3>
                    </div>
                </div>
                <div class="step-body">
                    <p>교재를 덮고, 강사가 기습 질문을 던집니다. 눈으로 읽는 영어가 아니라 <strong style="color:#0f172a;">입에서 바로 나올 때까지.</strong> 머리가 아니라 입이 기억할 때까지 반복합니다.</p>
                    <span class="force-tag">텍스트 의존 0%</span>
                </div>
            </div>

            <div class="step-card">
                <div class="step-header">
                    <div class="step-icon-wrap">
                        <img src="{{ asset('landing/b/step-icon-3.jpg') }}" alt="강제 롤플레이" loading="lazy">
                    </div>
                    <div class="step-label">
                        <div class="step-number">STEP 3</div>
                        <h3>강제 롤플레이</h3>
                    </div>
                </div>
                <div class="step-body">
                    <p>배운 표현을 실제 대화 상황에 그대로 투입합니다. 카페 주문, 회의 발표, 전화 영어 — <strong style="color:#0f172a;">실전에서 써먹을 수 있을 때까지 훈련은 끝나지 않습니다.</strong></p>
                    <span class="force-tag">실전 완벽 전환</span>
                </div>
            </div>

            <div class="step-bottom-text">
                <p>전담 강사가 매일 카카오톡으로 직접 관리합니다.<br><span class="accent">당신이 포기하려 해도, 강사가 안 놔줍니다.</span></p>
            </div>
        </div>
    </section>

    {{-- ===== 4주 커리큘럼 ===== --}}
    <section class="section section-gray">
        <div class="section-inner">
            <h2 style="text-align:center;">4주 만에 입이 트이는 커리큘럼</h2>
            <p style="text-align:center; color:#64748b; margin-bottom:24px;">"그래서 뭘 배우는 건데?" — 매주 체감되는 변화를 설계했습니다</p>

            <div class="curriculum-week">
                <div class="week-badge">WEEK 1</div>
                <h3>영어 입 트기</h3>
                <ul class="curriculum-list">
                    <li>매일 핵심 패턴 1개 암기 + 녹음 인증</li>
                    <li>기초 발음 교정 (한국인이 자주 틀리는 발음 집중)</li>
                    <li>자기소개, 일상 인사 롤플레이</li>
                </ul>
                <span class="curriculum-result">→ 영어로 입을 여는 것 자체가 자연스러워집니다</span>
            </div>

            <div class="curriculum-week">
                <div class="week-badge">WEEK 2</div>
                <h3>일상 회화 돌파</h3>
                <ul class="curriculum-list">
                    <li>상황별 필수 표현 (카페 주문, 길 묻기, 전화 받기)</li>
                    <li>실전 롤플레이 난이도 UP</li>
                    <li>틀린 문장 즉시 교정 + 복습 과제</li>
                </ul>
                <span class="curriculum-result">→ 해외여행에서 당황하지 않는 수준</span>
            </div>

            <div class="curriculum-week">
                <div class="week-badge">WEEK 3</div>
                <h3>의견 말하기 & 비즈니스</h3>
                <ul class="curriculum-list">
                    <li>찬반 토론 기초 (뉴스, 사회 이슈)</li>
                    <li>비즈니스 상황 표현 (회의, 이메일, 보고)</li>
                    <li>긴 문장 구사 훈련</li>
                </ul>
                <span class="curriculum-result">→ "I think..."로 시작하는 문장이 술술 나옵니다</span>
            </div>

            <div class="curriculum-week">
                <div class="week-badge">WEEK 4</div>
                <h3>자유 토론 & 자립</h3>
                <ul class="curriculum-list">
                    <li>Free Talking — 강사와 자유 대화</li>
                    <li>뉴스 영어, 시사 토론 실전</li>
                    <li>강사 없이도 유지하는 자기 학습법 정리</li>
                </ul>
                <span class="curriculum-result">→ 관리 없이도 스스로 루틴 유지 가능</span>
            </div>

            <p style="text-align:center; font-size:14px; font-weight:500; color:#64748b; margin-top:20px; line-height:1.7;">
                * 레벨테스트 결과에 따라 <span style="color:#0f172a; font-weight:700;">맞춤 커리큘럼</span>이 제공됩니다<br>
                <span style="color:#ef4444; font-weight:600;">초보부터 비즈니스 레벨까지 모두 대응</span>
            </p>
        </div>
    </section>

    {{-- ===== 수업 영상 ===== --}}
    <section class="section section-gray">
        <div class="section-inner">
            <h2 style="text-align:center; margin-bottom:20px;">실제 수업은 이렇게 진행됩니다</h2>
            <p style="text-align:center; color:#64748b; margin-bottom:16px;">2분이면 충분합니다. 실제 수업 분위기를 직접 확인하세요.</p>
            <div class="video-wrapper-b" id="videoWrapper" style="position:relative; cursor:pointer;" onclick="loadVideo()">
                <img src="{{ asset('landing/b/video-thumbnail.jpg') }}" alt="매일영 챌린지 수업 영상" style="width:100%; height:100%; object-fit:cover; border-radius:12px;" loading="lazy">
                <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                    <div style="width:64px; height:64px; background:rgba(239,68,68,0.9); border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(0,0,0,0.3);">
                        <span style="color:#fff; font-size:28px; margin-left:4px;">&#9654;</span>
                    </div>
                </div>
            </div>
            <p style="text-align:center; margin-top:20px;">
                <a href="https://www.pweng.net/level-test.php" class="hero-cta level-test-link" target="_blank" style="max-width:320px; margin:0 auto; font-size:16px; padding:14px 20px;">무료로 내 영어실력 확인하기</a>
            </p>
        </div>
    </section>

    {{-- ===== 역선택 (자격 부여) ===== --}}
    <section class="section section-white">
        <div class="section-inner" style="text-align:center;">
            <img src="{{ asset('landing/b/negative-select.jpg') }}" alt="신청 제한" style="width:80px; height:80px; border-radius:12px; margin:0 auto 16px; display:block;" loading="lazy">
            <h2>솔직히 말씀드립니다.<br>이런 분은 신청하지 마세요.</h2>
            <ul style="list-style:none; padding:0; margin:20px 0; text-align:left;">
                <li style="padding:10px 16px; margin-bottom:6px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; font-size:15px; color:#334155; display:flex; align-items:center; gap:10px;">
                    <span style="color:#ef4444; font-weight:700;">&#10007;</span> 아무 노력 없이 영어가 늘길 바라는 분
                </li>
                <li style="padding:10px 16px; margin-bottom:6px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; font-size:15px; color:#334155; display:flex; align-items:center; gap:10px;">
                    <span style="color:#ef4444; font-weight:700;">&#10007;</span> 매일 20분도 투자하기 싫은 분
                </li>
                <li style="padding:10px 16px; margin-bottom:6px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; font-size:15px; color:#334155; display:flex; align-items:center; gap:10px;">
                    <span style="color:#ef4444; font-weight:700;">&#10007;</span> 지적받는 것을 불편해하는 분
                </li>
                <li style="padding:10px 16px; margin-bottom:6px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; font-size:15px; color:#334155; display:flex; align-items:center; gap:10px;">
                    <span style="color:#ef4444; font-weight:700;">&#10007;</span> 시작만 하다 말 가능성이 높은 분
                </li>
            </ul>
            <p style="font-size:16px; font-weight:600; color:#0f172a; line-height:1.7;">
                하지만 "이번엔 진짜 해보겠다"는 분이라면,<br>
                <span style="color:#ef4444;">저희가 끝까지 잡아드리겠습니다.</span>
            </p>
        </div>
    </section>

    {{-- ===== 사회적 증거 ===== --}}
    <section class="section section-dark">
        <div class="section-inner">
            <h2 style="text-align:center; margin-bottom:24px;">이미 검증된 결과</h2>

            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-number">12,849</span>
                    <span class="stat-label">누적 참여자</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">9.8/10</span>
                    <span class="stat-label">평균 만족도</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">73%</span>
                    <span class="stat-label">재등록률 (업계 평균 23%)</span>
                </div>
            </div>

            <p style="text-align:center; font-size:13px; color:#94a3b8; margin-bottom:16px;">수강 후기 1,247건 중 발췌</p>

            @php
            $reviews = [
                ['name' => '강서영', 'img' => 'review-profile-1.jpg', 'label' => '수업 후기', 'body' => '솔직히 처음 2주는 녹음 과제가 너무 스트레스였어요. 매일 녹음해서 보내야 수업이 열리는 구조라 도망칠 수가 없더라고요. 근데 3주차쯤 되니까 입에서 문장이 그냥 나오기 시작했어요. 소름이었습니다. 지금 5개월째인데, 이제 녹음이 습관이 됐어요.'],
                ['name' => '류은정', 'img' => 'review-profile-2.jpg', 'label' => '수업 후기', 'body' => '발음 틀리면 바로바로 잡아주시는데, 교재 안 보고 말해야 해서 처음엔 멘붕이었어요. 근데 그게 포인트더라고요. 눈으로 읽으면 다 아는 것 같은데 입으로는 안 나오잖아요. 지금은 교재 없이도 문장이 나와요.'],
                ['name' => '양예은', 'img' => 'review-profile-3.jpg', 'label' => '수업 후기', 'body' => '카페 주문 롤플레이하는데 진짜 카페에 온 것처럼 하시더라고요. 처음엔 쑥스러웠는데 매일 반복하니까 진짜 해외 카페에서 주문할 때 입이 먼저 움직였어요. 매일 20분이 이렇게 큰 차이를 만드는 줄 몰랐습니다.'],
                ['name' => '이인호', 'img' => 'review-profile-4.jpg', 'label' => '수업 후기', 'body' => '녹음 과제 안 올리면 수업이 안 열려서 어쩔 수 없이 했거든요. 근데 강사님이 카톡으로 매일 체크해주시니까 빠질 수가 없더라고요. 2주 지나니까 습관이 됐고, 이 나이에 영어 루틴이 잡힐 줄 몰랐습니다.'],
                ['name' => '전서연', 'img' => 'review-profile-5.jpg', 'label' => '수업 후기', 'body' => '교재 덮고 말하라고 할 때 진짜 막막했어요. 근데 틀리면 바로 고쳐주시고, 그 문장을 다시 말하게 하시거든요. 매일 하니까 확실히 느는 게 느껴져요. 한 달 전의 녹음이랑 비교하면 완전 다른 사람이에요.'],
                ['name' => '손영희', 'img' => 'review-profile-6.jpg', 'label' => '수업 후기', 'body' => '40대 워킹맘이라 시간 없다는 핑계를 항상 댔는데, 강사님이 카톡으로 오늘 녹음 아직이요~ 하고 들어오시니까 안 할 수가 없어요. 이 강제성이 저한테는 딱 맞았어요. 아이 재우고 20분이면 되니까요.'],
                ['name' => '김수지', 'img' => 'review-profile-7.jpg', 'label' => '수업 후기', 'body' => '회의 상황 롤플레이할 때 외운 표현을 바로 써먹어야 하는데, 처음엔 버벅거렸거든요. 근데 3개월 하고 나니까 실제 영어 미팅에서 문장이 그냥 나왔어요. 동료들이 깜짝 놀랐습니다. 교재 안 보고 뱉는 훈련이 진짜 효과 있더라고요.'],
                ['name' => '류은경', 'img' => 'review-profile-8.jpg', 'label' => '수업 후기', 'body' => '매일 녹음 올리는 거 처음엔 정말 싫었는데, 한 달 치 녹음을 다시 들어보니까 제가 얼마나 늘었는지 증거가 쌓여 있더라고요. 안 빠지고 매일 했더니 영어가 일상이 됐어요. 강제로 시켜주는 구조가 아니면 절대 못 했을 거예요.'],
            ];
            @endphp

            @foreach($reviews as $review)
            <div class="review-card-b">
                <div class="review-header">
                    @if(isset($review['img']))
                        <img src="{{ asset('landing/b/' . $review['img']) }}" alt="{{ $review['name'] }}" class="review-avatar" loading="lazy">
                    @else
                        <div class="review-avatar-initial" style="background:{{ $review['color'] }};">{{ mb_substr($review['name'], 0, 1) }}</div>
                    @endif
                    <div class="review-meta">
                        <div class="review-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="review-author-b">{{ $review['name'] }} · {{ $review['label'] }}</div>
                    </div>
                </div>
                <div class="review-text">"{{ $review['body'] }}"</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ===== 권위/업력 배너 ===== --}}
    <section class="section section-dark" style="padding:36px 20px;">
        <div class="section-inner" style="text-align:center;">
            <p style="font-size:14px; color:#94a3b8; font-weight:400; margin-bottom:20px;">와이즈에듀케이션 · 2016년부터 영어 스피킹 전문 교육</p>
            <div style="display:flex; justify-content:center; gap:28px; flex-wrap:wrap; margin-bottom:20px;">
                <div style="text-align:center;">
                    <span style="font-size:26px; font-weight:800; color:#fbbf24; display:block; line-height:1.2;">10년+</span>
                    <span style="font-size:12px; color:#94a3b8; margin-top:4px; display:block;">운영 기간</span>
                </div>
                <div style="width:1px; background:rgba(255,255,255,0.15); align-self:stretch;"></div>
                <div style="text-align:center;">
                    <span style="font-size:26px; font-weight:800; color:#fbbf24; display:block; line-height:1.2;">12,000+</span>
                    <span style="font-size:12px; color:#94a3b8; margin-top:4px; display:block;">누적 수강생</span>
                </div>
                <div style="width:1px; background:rgba(255,255,255,0.15); align-self:stretch;"></div>
                <div style="text-align:center;">
                    <span style="font-size:26px; font-weight:800; color:#fbbf24; display:block; line-height:1.2;">9.8/10</span>
                    <span style="font-size:12px; color:#94a3b8; margin-top:4px; display:block;">평균 만족도</span>
                </div>
            </div>
            <p style="font-size:12px; color:#64748b; margin:0;">파워잉글리쉬 (pweng.net) 운영사</p>
        </div>
    </section>

    {{-- ===== 무료레벨테스트 CTA ===== --}}
    <section id="lead-form" class="section section-white" style="text-align:center;">
        <div class="section-inner">
            {{-- 1. 헤드라인 (희소성 + 가격 앵커링) --}}
            <img src="{{ asset('landing/b/price-anchor.jpg') }}" alt="무료 혜택" style="width:120px; height:auto; margin:0 auto 12px; display:block; border-radius:8px;" loading="lazy">
            <p style="font-size:15px; color:#94a3b8; margin-bottom:6px;"><s>정가 150,000원</s> <span style="color:#ef4444; font-weight:700;">→ 지금 무료</span></p>
            <h2>15만 원 상당의 1:1 레벨 진단,<br>이번 달 무료</h2>
            <p style="color:#64748b; margin-bottom:8px;">이번 달 무료 레벨테스트, 마감까지 얼마 안 남았습니다.</p>

            {{-- 2. FOMO 텍스트 (손실 회피) --}}
            <div class="fomo-text" style="margin-top:0; margin-bottom:16px;">
                이번 주에만 <strong>127명</strong>이 새로 시작했습니다.<br>
                매일 미루는 사이, 다른 사람은 영어가 늘고 있습니다.
            </div>

            {{-- 3. 카운트다운 (긴급성) --}}
            <div class="countdown-wrap" style="margin-top:0;">
                <div class="countdown-label">이번 달 무료체험 마감까지</div>
                <div class="countdown-timer" id="countdown">
                    <div class="countdown-unit">
                        <span class="countdown-num" id="cd-days">00</span>
                        <span class="countdown-txt">일</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-num" id="cd-hours">00</span>
                        <span class="countdown-txt">시간</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-num" id="cd-mins">00</span>
                        <span class="countdown-txt">분</span>
                    </div>
                    <div class="countdown-unit">
                        <span class="countdown-num" id="cd-secs">00</span>
                        <span class="countdown-txt">초</span>
                    </div>
                </div>
            </div>

            {{-- 4. 신뢰 뱃지 이미지 (장벽 제거) --}}
            <img src="{{ asset('landing/b/trust-badge.jpg') }}" alt="누적 수강생 12,000+ · 만족도 9.8 · 100% 환불보장" class="trust-badge-img" loading="lazy">

            {{-- 5. CTA 버튼 (행동) --}}
            <a href="https://www.pweng.net/level-test.php" class="hero-cta level-test-link" target="_blank" style="margin:24px auto 16px;">무료로 내 영어실력 확인하기</a>

            {{-- 6. 텍스트 신뢰 뱃지 (마지막 안심) --}}
            <div class="trust-badges">
                <span class="trust-badge"><span class="badge-icon">&#10003;</span> 100% 무료</span>
                <span class="trust-badge"><span class="badge-icon">&#10003;</span> 강제 결제 없음</span>
                <span class="trust-badge"><span class="badge-icon">&#10003;</span> 30초면 완료</span>
            </div>
        </div>
    </section>

    {{-- ===== 상세 정보 (접이식) ===== --}}
    <section class="section section-gray info-section">
        <div class="section-inner">
            <h2 style="margin-bottom:24px;">자주 묻는 질문</h2>

            <div class="accordion-item">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    매일영 챌린지가 정확히 뭔가요?
                    <span class="arrow">&#9660;</span>
                </div>
                <div class="accordion-body">
                    단순한 인강이나 수다 떠는 전화영어가 아닙니다. 매일 수행하는 영어 말하기 과제 + 전담 강사의 1:1 교정 피드백 + 틀린 문장을 다시 말하게 만드는 복습 구조. 공부를 안 할 수 없게 만드는 운영 시스템입니다.
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    완전 초보인데도 가능한가요?
                    <span class="arrow">&#9660;</span>
                </div>
                <div class="accordion-body">
                    네, 가능합니다. 영어로 거의 말해본 적 없는 스피킹 제로베이스 학습자를 기준으로 설계되었습니다.
                    <ul>
                        <li>문법을 알긴 하는데 말이 안 나오는 분</li>
                        <li>단어만 외우다 끝났던 분</li>
                        <li>영어 공부를 다시 시작하고 싶은 분</li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    매일 참여해야 하나요?
                    <span class="arrow">&#9660;</span>
                </div>
                <div class="accordion-body">
                    네, 매일 참여하는 것을 전제로 설계된 프로그램입니다. 다만 하루 학습 분량은 20분 내외로, 직장인·학생 모두 병행이 가능합니다. 고정 시간 출석이나 예약 수업 없이 본인이 가능한 시간에 수행하면 됩니다.
                </div>
            </div>

            <div class="accordion-item">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    매일영 챌린지의 목표는 뭔가요?
                    <span class="arrow">&#9660;</span>
                </div>
                <div class="accordion-body">
                    영어를 "공부 대상"이 아니라 매일 사용하는 도구로 만드는 것. 과정이 끝났을 때 누군가의 관리 없이도 스스로 영어 스피킹 루틴을 유지할 수 있다면 이 챌린지는 성공입니다.
                </div>
            </div>
        </div>
    </section>

    {{-- ===== 카카오 문의 ===== --}}
    <div class="kakao-section">
        <img src="{{ asset('landing/b/kakao-consult.jpg') }}" alt="카카오톡 상담" class="kakao-image" loading="lazy">
        <h2>아직 결정이 안 되시나요?</h2>
        <p>5초 만에 답변 드립니다. 부담 없이 물어보세요.</p>
        <a href="https://pf.kakao.com/_elxhdl" target="_blank" class="kakao-btn">
            <img src="{{ asset('landing/KakaoTalk_logo.png') }}" alt="KakaoTalk">
            카카오 문의
        </a>
    </div>

    {{-- ===== 푸터 ===== --}}
    <footer class="footer-b">
        <div class="footer-logo-b">Wise Education I Co., Ltd.</div>
        <div class="footer-social-b">
            <a href="https://www.facebook.com/pweng.net/" target="_blank" aria-label="Facebook">
                <img src="{{ asset('landing/facebook.png') }}" alt="Facebook">
            </a>
            <a href="https://www.instagram.com/pweng_english/" target="_blank" aria-label="Instagram">
                <img src="{{ asset('landing/instagram.png') }}" alt="Instagram">
            </a>
            <a href="https://blog.naver.com/pweng8672" target="_blank" aria-label="Blog">
                <img src="{{ asset('landing/blog.png') }}" alt="Blog">
            </a>
        </div>
        <nav class="footer-nav-b">
            <a href="https://m.pweng.net/login-v2.php">로그인</a>
            <a href="https://m.pweng.net/me/support.php">상담 요청</a>
            <a href="https://m.pweng.net/faq-v2.php">FAQ</a>
            <a href="https://m.pweng.net/term-of-use.php">이용약관</a>
            <a href="https://m.pweng.net/privacy-policy.php">개인정보 처리방침</a>
        </nav>
        <div class="footer-info-b">
            <p>와이즈에듀케이션아이(주) 사이트명: 파워잉글리쉬 대표이사 전상현</p>
            <p>사업자등록번호: 217-81-44736 통신판매신고번호: 2014-서울도봉-0233호</p>
            <p>서울본사: 서울시 노원구 한글비석로 245 두타빌 B동 7층 713호</p>
            <p>대표번호: 1688-8672 개인정보관리 책임자: 안희영</p>
        </div>
    </footer>

    {{-- ===== 플로팅 CTA ===== --}}
    <div class="floating-cta" id="floatingCta">
        <a href="https://www.pweng.net/level-test.php" class="floating-cta-btn level-test-link" target="_blank">무료로 내 영어실력 확인하기</a>
    </div>

    {{-- ===== 실시간 토스트 ===== --}}
    <div class="toast-notification" id="toastNotification">
        <span class="toast-dot"></span>
        <span id="toastText"></span>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

    // ===== 비디오 썸네일 클릭 → iframe 로드 =====
    function loadVideo() {
        var wrapper = document.getElementById('videoWrapper');
        if (!wrapper) return;
        wrapper.onclick = null;
        wrapper.style.cursor = 'default';
        wrapper.innerHTML = '<iframe src="https://www.youtube.com/embed/bNwXm93di54?autoplay=1" title="매일영 챌린지 수업 영상" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="width:100%;height:100%;border:0;border-radius:12px;"></iframe>';
    }

    // ===== 아코디언 =====
    function toggleAccordion(header) {
        var body = header.nextElementSibling;
        var isOpen = body.classList.contains('show');
        // 모두 닫기
        document.querySelectorAll('.accordion-body').forEach(function(b) { b.classList.remove('show'); });
        document.querySelectorAll('.accordion-header').forEach(function(h) { h.classList.remove('active'); });
        if (!isOpen) {
            body.classList.add('show');
            header.classList.add('active');
        }
    }

    // ===== 플로팅 CTA =====
    (function() {
        var floating = document.getElementById('floatingCta');
        var formSection = document.getElementById('lead-form');
        if (!floating) return;
        window.addEventListener('scroll', function() {
            var scrollY = window.scrollY || window.pageYOffset;
            if (scrollY > 300) {
                // 폼이 화면에 보이면 플로팅 숨김
                if (formSection) {
                    var rect = formSection.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        floating.classList.remove('show');
                        return;
                    }
                }
                floating.classList.add('show');
            } else {
                floating.classList.remove('show');
            }
        });
    })();

    // ===== 카운트다운 타이머 (이번 달 말일 자정까지) =====
    (function() {
        var now = new Date();
        var endOfMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);
        function update() {
            var diff = endOfMonth - new Date();
            if (diff <= 0) diff = 0;
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            var dEl = document.getElementById('cd-days');
            var hEl = document.getElementById('cd-hours');
            var mEl = document.getElementById('cd-mins');
            var sEl = document.getElementById('cd-secs');
            if (dEl) dEl.textContent = d < 10 ? '0' + d : d;
            if (hEl) hEl.textContent = h < 10 ? '0' + h : h;
            if (mEl) mEl.textContent = m < 10 ? '0' + m : m;
            if (sEl) sEl.textContent = s < 10 ? '0' + s : s;
        }
        update();
        setInterval(update, 1000);
    })();

    // ===== 실시간 조회수 & 잔여석 (localStorage 유지) =====
    (function() {
        var viewersEl = document.getElementById('live-viewers');
        if (!viewersEl) return;
        viewersEl.textContent = Math.floor(Math.random() * 11) + 20; // 초기값 20~30 랜덤

        // 조회수 변동 (20~30명 범위)
        setInterval(function() {
            var current = parseInt(viewersEl.textContent);
            var change = Math.floor(Math.random() * 7) - 3; // -3 ~ +3
            var next = Math.max(20, Math.min(30, current + change));
            viewersEl.textContent = next;
        }, 5000);

        // 잔여석 (localStorage로 새로고침 시 유지)
        var seatsEl = document.getElementById('remaining-seats');
        if (!seatsEl) return;

        var savedSeats = null;
        try { savedSeats = localStorage.getItem('mc_seats'); } catch(e) {}
        var savedTime = null;
        try { savedTime = localStorage.getItem('mc_seats_time'); } catch(e) {}
        var now = Date.now();

        if (savedSeats !== null && savedTime && (now - parseInt(savedTime)) < 86400000) {
            var s = parseInt(savedSeats);
            if (s >= 0 && s <= 12) {
                if (s <= 0) {
                    seatsEl.parentElement.innerHTML = '<span style="color:#fde68a;font-weight:700;">마감되었습니다 — 대기자 등록 가능</span>';
                } else if (s <= 3) {
                    seatsEl.parentElement.innerHTML = '무료체험 잔여 <span class="seats" id="remaining-seats" style="color:#ef4444;font-weight:800;">' + s + '</span>석 <span style="color:#fde68a;font-size:12px;animation:pulse-dot 1s infinite;">마감 임박!</span>';
                } else {
                    seatsEl.textContent = s;
                }
            }
        }

        setInterval(function() {
            var el = document.getElementById('remaining-seats');
            if (!el) return;
            var current = parseInt(el.textContent);
            if (isNaN(current) || current <= 0) return;
            if (Math.random() > 0.85) {
                var next = current - 1;
                try {
                    localStorage.setItem('mc_seats', next);
                    localStorage.setItem('mc_seats_time', Date.now());
                } catch(e) {}
                if (next <= 3 && next > 0) {
                    el.parentElement.innerHTML = '무료체험 잔여 <span class="seats" id="remaining-seats" style="color:#ef4444;font-weight:800;">' + next + '</span>석 <span style="color:#fde68a;font-size:12px;animation:pulse-dot 1s infinite;">마감 임박!</span>';
                } else if (next <= 0) {
                    el.parentElement.innerHTML = '<span style="color:#fde68a;font-weight:700;">마감되었습니다 — 대기자 등록 가능</span>';
                } else {
                    el.textContent = next;
                }
            }
        }, 15000);
    })();

    // ===== 실시간 레벨테스트 신청 토스트 =====
    (function() {
        var toastData = [
            { region: '서울 강남구', name: '김○○', phone: '7824' },
            { region: '서울 마포구', name: '이○○', phone: '3156' },
            { region: '경기 성남시', name: '박○○', phone: '9402' },
            { region: '서울 송파구', name: '최○○', phone: '5531' },
            { region: '인천 남동구', name: '정○○', phone: '2278' },
            { region: '서울 영등포구', name: '한○○', phone: '6643' },
            { region: '경기 수원시', name: '윤○○', phone: '8817' },
            { region: '부산 해운대구', name: '장○○', phone: '1294' },
            { region: '서울 서초구', name: '오○○', phone: '4456' },
            { region: '대전 유성구', name: '신○○', phone: '7103' },
            { region: '서울 노원구', name: '조○○', phone: '3389' },
            { region: '경기 고양시', name: '임○○', phone: '5672' },
            { region: '서울 관악구', name: '황○○', phone: '9248' },
            { region: '대구 수성구', name: '권○○', phone: '1537' },
            { region: '서울 강동구', name: '안○○', phone: '6091' },
            { region: '경기 용인시', name: '유○○', phone: '8365' },
            { region: '서울 동작구', name: '홍○○', phone: '2714' },
            { region: '광주 서구', name: '문○○', phone: '4928' },
            { region: '서울 종로구', name: '배○○', phone: '7546' },
            { region: '경기 화성시', name: '허○○', phone: '3082' },
            { region: '서울 은평구', name: '나○○', phone: '6417' },
            { region: '울산 남구', name: '전○○', phone: '1853' },
            { region: '서울 광진구', name: '차○○', phone: '5296' },
            { region: '경기 파주시', name: '송○○', phone: '9734' },
            { region: '서울 중구', name: '강○○', phone: '4168' },
        ];
        var toast = document.getElementById('toastNotification');
        var toastText = document.getElementById('toastText');
        if (!toast || !toastText) return;
        var idx = 0;
        function showToast() {
            var d = toastData[idx % toastData.length];
            var mins = Math.floor(Math.random() * 5) + 1;
            toastText.innerHTML = d.name + '님 <span style="color:#94a3b8;font-size:12px;">(010-****-' + d.phone + ')</span> ' + mins + '분 전 <strong style="color:#10b981;">레벨테스트 신청</strong>';
            toast.classList.add('show');
            setTimeout(function() { toast.classList.remove('show'); }, 3500);
            idx++;
        }
        setTimeout(showToast, 5000);
        setInterval(showToast, 12000);
    })();


    // ===== 부드러운 스크롤 (앵커 링크) =====
    document.querySelectorAll('a[href^="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute('href').substring(1);
            var target = document.getElementById(id);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ===== 디바이스별 링크 분기 (level-test, dynamic-link) =====
    (function() {
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }
        var linkMapping = {
            'level-test': {
                mobile: 'https://m.pweng.net/level-test.php',
                pc: 'https://www.pweng.net/level-test.php'
            },
            'login': { mobile: 'https://m.pweng.net/login-v2.php', pc: 'https://www.pweng.net/login-v2.php' },
            'support': { mobile: 'https://m.pweng.net/me/support.php', pc: 'https://www.pweng.net/me/support.php' },
            'faq': { mobile: 'https://m.pweng.net/faq-v2.php', pc: 'https://www.pweng.net/faq.php' },
            'terms': { mobile: 'https://m.pweng.net/term-of-use.php', pc: 'https://www.pweng.net/agreement.php#-agreement' },
            'privacy': { mobile: 'https://m.pweng.net/privacy-policy.php', pc: 'https://www.pweng.net/agreement.php#-policy' }
        };
        function updateLinks() {
            var isMobile = isMobileDevice();
            document.querySelectorAll('.level-test-link').forEach(function(link) {
                link.href = isMobile ? linkMapping['level-test'].mobile : linkMapping['level-test'].pc;
            });
            document.querySelectorAll('.dynamic-link').forEach(function(link) {
                var type = link.getAttribute('data-link-type');
                if (linkMapping[type]) {
                    link.href = isMobile ? linkMapping[type].mobile : linkMapping[type].pc;
                }
            });
        }
        updateLinks();
        window.addEventListener('resize', updateLinks);
    })();

    // CTA 클릭 트래킹
    (function() {
        var tracked = false;
        document.querySelectorAll('.level-test-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (tracked) return;
                tracked = true;
                var data = new FormData();
                data.append('variant', '{{ $variant }}');
                data.append('button_type', 'level-test');
                navigator.sendBeacon('/api/cta-click', data);
            });
        });
    })();
    </script>
</body>
</html>
