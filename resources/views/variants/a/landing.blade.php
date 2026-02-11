<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="영어공부, 영어회화, 영어실력 향상, 영어학습 방법, 영어챌린지, 매일영 챌린지, 매일영챌린지, 매일영첼린지, 매일영 첼린지, Maeil English Challenge, 영어 실력 향상의 현실적인 방법, 한 달 만에 영어 가능할까, 과장 없는 영어 학습 프로그램, 영어 공부 기대와 현실, 꾸준함으로 영어 실력 올리는 법, 실전 중심 영어 학습법">
    <meta name="description" content="영어 실력 향상의 현실적인 방법, 한 달 만에 영어 가능할까? 과장 없는 영어 학습 프로그램으로 꾸준함으로 영어 실력 올리는 법을 제시합니다. 실전 중심 영어 학습법, 매일영 챌린지로 영어공부와 영어회화 실력을 향상시켜보세요.">
    <title>매일영 챌린지</title>

    <!-- OpenGraph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="매일영 챌린지">
    <meta property="og:locale" content="ko_KR">
    <meta property="og:title" content="의지는 필요 없습니다. 입이 트이는 영어 강제 루틴, 매일영 챌린지">
    <meta property="og:description" content="한 달 만에 원어민이 되는 기적은 없습니다. 하지만 매일 영어를 뱉을 수밖에 없는 시스템으로 당신의 영어 근육을 확실히 만듭니다.">
    <meta property="og:image" content="{{ asset('landing/thumbnail.jpg') }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="400">
    <meta property="og:image:alt" content="매일영 챌린지 대표 이미지">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="의지는 필요 없습니다. 입이 트이는 영어 강제 루틴, 매일영 챌린지">
    <meta name="twitter:description" content="한 달 만에 원어민이 되는 기적은 없습니다. 하지만 매일 영어를 뱉을 수밖에 없는 시스템으로 당신의 영어 근육을 확실히 만듭니다.">
    <meta name="twitter:image" content="{{ asset('landing/thumbnail.jpg') }}">
    <meta name="twitter:image:alt" content="매일영 챌린지 대표 이미지">

    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#112747">
    <meta name="apple-mobile-web-app-title" content="매일영 챌린지">
    <meta name="application-name" content="매일영 챌린지">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Noto+Sans+KR:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('landing/Image20260107150048.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landing/Image20260107150048.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landing/Image20260107150048.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('landing/Image20260107150048.png') }}">
    <link rel="shortcut icon" href="{{ asset('landing/Image20260107150048.png') }}">

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
        src: url('{{ asset('landing/fonts/SCDream2.otf') }}') format('opentype');
        font-weight: 200;
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
        html, body {
        font-family: 'TheSCoD', 'Noto Sans KR', 'Noto Sans', sans-serif;
        font-weight: 300;
        font-size: 1rem;
        margin: 0;
        padding: 0;
        background-color: #000000;
        scroll-behavior: smooth;
        width: 100%;
        max-width: 100vw;
        }

        body {
        position: relative;
        }

        .promo-banner {
        background-color: #112747;
        padding: 14px 20px;
        text-align: center;
        width: 100%;
        max-width: 100%;
        border-bottom: none;
        box-sizing: border-box;
        }

        .promo-banner a {
        text-decoration: none;
        color: #FFFFFF;
        font-size: 0.95rem;
        font-weight: 400;
        display: block;
        line-height: 1.5;
        text-align: center;
        width: 100%;
        }

        .promo-banner a:hover {
        color: #FFFFFF;
        }

        .promo-banner .highlight {
        font-weight: 600;
        }

        .promo-banner .arrow {
        margin-left: 2px;
        display: inline-block;
        }

        .navbar-custom {
        background-color: #FFFFFF;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 100%;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-sizing: border-box;
        }

        .navbar-nav-custom {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
        align-items: center;
        position: relative;
        }

        .navbar-nav-custom::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 300px;
        height: 2px;
        background-color: #E60013;
        transition: transform 0.2s ease-out;
        transform: translateX(0);
        }

        .navbar-nav-custom[data-active="1"]::after {
        transform: translateX(300px);
        }

        .navbar-nav-custom[data-active="2"]::after {
        transform: translateX(600px);
        }

        .navbar-nav-custom li {
        height: 100%;
        display: flex;
        align-items: center;
        width: 300px;
        }

        .navbar-nav-custom a {
        color: #606466;
        text-decoration: none;
        padding: 0 20px;
        height: 100%;
        width: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        font-weight: 400;
        position: relative;
        transition: color 0.3s ease;
        }

        .navbar-nav-custom a.active {
        color: #333333;
        }

        .navbar-nav-custom a:hover {
        color: #606466;
        }

        .hero-section {
        background-color: #000000;
        width: 100%;
        max-width: 100%;
        position: relative;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        box-sizing: border-box;
        }

        .hero-wrapper {
        position: relative;
        width: 100%;
        max-width: 1920px;
        }

        .hero-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, #C9E8FF, #F7E7FA);
        z-index: 0;
        pointer-events: none;
        }

        .hero-bg {
        width: 100%;
        height: 340px;
        display: block;
        }

        .hero-content {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 900px;
        max-width: 95%;
        height: 340px;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        gap: 0px;
        box-sizing: border-box;
        padding: 0;
        }

        .hero-text {
        color: #000000;
        width: 540px;
        height: 340px;
        z-index: 2;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        }

        .hero-text h1 {
        font-weight: 700;
        font-size: 40px;
        line-height: 52px;
        margin: 0 0 10px 0;
        width: 540px;
        }

        .hero-text p {
        font-weight: 400;
        font-size: 19.2px;
        line-height: 28.8px;
        margin: 0;
        width: 540px;
        }

        .hero-image {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        z-index: 1;
        width: 220px;
        height: 340px;
        flex-shrink: 0;
        margin-left: 0;
        }

        .hero-image img {
        width: 220px;
        height: 300px;
        display: block;
        }

        .content-section {
        width: 100%;
        max-width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 0;
        box-sizing: border-box;
        }

        .content-section:nth-of-type(odd) {
        background-color: #f2f4f7;
        }

        .content-section:nth-of-type(even) {
        background-color: #ffffff;
        }

        .section-inner {
        width: 900px;
        max-width: 95%;
        box-sizing: border-box;
        }

        .section-inner h2 {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.4;
        margin: 0 0 16px 0;
        color: #000000;
        }

        .section-inner p {
        font-size: 18px;
        font-weight: 300;
        line-height: 1.6;
        margin: 0 0 16px 0;
        color: #000000;
        }

        .section-inner p:last-child {
        margin: 0;
        }

        .section-inner ul {
        list-style: none;
        padding: 0;
        margin: 16px 0;
        }

        .section-inner ul li {
        font-size: 18px;
        font-weight: 300;
        line-height: 1.6;
        margin: 8px 0;
        color: #000000;
        padding-left: 20px;
        position: relative;
        }

        .section-inner ul li:before {
        content: "\2022";
        position: absolute;
        left: 0;
        }

        .section-inner ul.square-bullets li {
        padding-left: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        line-height: 1.6;
        }

        .section-inner ul.square-bullets li:before {
        content: attr(data-number);
        position: static;
        background-color: #000000;
        color: #ffffff;
        width: 18px;
        height: 18px;
        min-width: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 300;
        flex-shrink: 0;
        margin-top: 0;
        border-radius: 2px;
        line-height: 1;
        }

        .cta-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        }

        .cta-text h2 {
        margin-bottom: 8px;
        }

        .cta-text p {
        margin: 0;
        }

        .kakao-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #FEE500;
        color: #000000;
        text-decoration: none;
        padding: 14px 28px;
        border-radius: 25px;
        font-size: 18px;
        font-weight: 600;
        gap: 8px;
        transition: background-color 0.3s;
        white-space: nowrap;
        }

        .kakao-button:hover {
        background-color: #FDD835;
        color: #000000;
        }

        .kakao-button img {
        width: 24px;
        height: 24px;
        }

        .cta-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #FF3D5C;
        color: #FFFFFF;
        text-decoration: none;
        width: auto;
        min-height: 60px;
        height: auto;
        padding: 16px 32px;
        border-radius: 5px;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.4;
        margin: 24px;
        overflow: visible;
        box-sizing: border-box;
        white-space: nowrap;
        }

        .cta-button:hover {
        background-color: #E63552;
        color: #FFFFFF;
        }

        .cards-container {
        width: 900px;
        margin: 24px auto;
        position: relative;
        transform-origin: center top;
        }

        .card-number {
        width: 40px;
        height: 38px;
        font-weight: 600;
        color: #C1BFCE;
        margin-bottom: 20px;
        font-size: 32px;
        }

        .card-icon {
        position: absolute;
        bottom: 36px;
        left: 710px;
        width: 149px;
        height: 167px;
        object-fit: contain;
        }

        .cards-container > div h2,
        .cards-container > div p,
        .cards-container > div ul {
        max-width: 650px;
        }

        .footer {
        background-color: #f8f8f8;
        width: 100%;
        max-width: 100%;
        display: flex;
        justify-content: center;
        padding: 40px 0;
        box-sizing: border-box;
        }

        .footer-inner {
        width: 900px;
        max-width: 95%;
        box-sizing: border-box;
        }

        .footer-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        }

        .footer-left {
        display: flex;
        flex-direction: column;
        gap: 16px;
        }

        .footer-info {
        font-size: 11px;
        font-weight: 300;
        line-height: 1.7;
        color: #666666;
        text-align: left;
        max-width: 500px;
        order: 1;
        }

        .footer-info p {
        margin: 0 0 4px 0;
        }

        .footer-social {
        display: flex;
        gap: 12px;
        order: 2;
        }

        .footer-social a {
        width: 32px;
        height: 32px;
        background-color: #000000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        }

        .footer-social a:hover {
        background-color: #333333;
        }

        .footer-social img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        }

        .footer-logo {
        display: flex;
        align-items: center;
        gap: 0;
        order: 3;
        }

        .footer-logo img {
        display: none;
        }

        .footer-logo-text {
        font-size: 14px;
        color: #000000;
        font-weight: 300;
        }

        .footer-logo-text .bold {
        font-weight: 700;
        }

        .footer-logo-text .regular {
        font-weight: 300;
        }

        .footer-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        }

        .footer-nav {
        display: grid;
        grid-template-columns: repeat(3, auto);
        gap: 12px 40px;
        }

        .footer-nav a {
        color: #000000;
        text-decoration: none;
        font-size: 13px;
        font-weight: 300;
        white-space: nowrap;
        text-align: right;
        }

        .footer-nav a:hover {
        color: #666666;
        }

        .footer-mobile {
        display: none;
        }

        .video-wrapper {
            max-width: 600px;
            aspect-ratio: 2 / 1;
            margin: 24px auto 0;
        }

        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .spec-image {
            width: 900px;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 24px auto 0;
        }

        .spec-image:first-of-type {
            margin-top: 24px;
        }

        .review-card {
        width: 100%;
        max-width: 900px;
        background-color: white;
        padding: 16px 16px 16px 16px;
        box-sizing: border-box;
        position: relative;
        }

        .review-stars-container {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 8px;
        }

        .review-star {
        color: #FEA439;
        font-size: 12px;
        }

        .review-rating-text {
        font-size: 12px;
        font-weight: 300;
        margin-left: 4px;
        }

        .review-author {
        font-size: 12px;
        font-weight: 300;
        text-align: left;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        }

        .review-label-pill {
        font-size: 10px;
        font-weight: 300;
        color: #00A6FD;
        background: transparent;
        border: 1px solid #00A6FD;
        border-radius: 50px;
        padding: 2px 8px;
        display: inline-block;
        }

        .review-body {
        font-size: 12px;
        font-weight: 300;
        text-align: left;
        line-height: 1.5;
        }

        /* ========== Lead Form Styles ========== */
        .lead-form-section {
        background-color: #ffffff;
        width: 100%;
        max-width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 0;
        box-sizing: border-box;
        }

        .lead-form-inner {
        width: 500px;
        max-width: 95%;
        box-sizing: border-box;
        }

        .lead-form-inner h2 {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.4;
        margin: 0 0 8px 0;
        color: #000000;
        text-align: center;
        }

        .lead-form-inner p.subtitle {
        font-size: 16px;
        font-weight: 300;
        line-height: 1.6;
        margin: 0 0 24px 0;
        color: #666666;
        text-align: center;
        }

        .lead-form-inner label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333333;
        margin-bottom: 6px;
        }

        .lead-form-inner input[type="text"],
        .lead-form-inner input[type="tel"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
        margin-bottom: 16px;
        box-sizing: border-box;
        transition: border-color 0.2s;
        }

        .lead-form-inner input[type="text"]:focus,
        .lead-form-inner input[type="tel"]:focus {
        outline: none;
        border-color: #FF3D5C;
        }

        .lead-form-inner .privacy-check {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #666;
        }

        .lead-form-inner .privacy-check input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        }

        .lead-form-inner .privacy-check a {
        color: #FF3D5C;
        text-decoration: underline;
        }

        .lead-form-inner .submit-btn {
        width: 100%;
        padding: 16px;
        background-color: #FF3D5C;
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 600;
        font-family: 'TheSCoD', 'Noto Sans KR', sans-serif;
        cursor: pointer;
        transition: background-color 0.3s;
        }

        .lead-form-inner .submit-btn:hover {
        background-color: #E63552;
        }

        .lead-form-inner .submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        }

        .lead-form-inner .error-msg {
        color: #E63552;
        font-size: 12px;
        margin-top: -12px;
        margin-bottom: 12px;
        display: none;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
        .promo-banner {
        padding: 10px 15px;
        text-align: center;
        }

        .promo-banner a {
        font-size: 0.85rem;
        display: block;
        width: 100%;
        text-align: center;
        line-height: 1.6;
        }

        .navbar-custom {
        height: 50px;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        justify-content: center;
        padding: 0 2px;
        }

        .navbar-nav-custom {
        flex-direction: row;
        width: auto;
        min-width: auto;
        justify-content: center;
        height: 50px;
        padding: 0;
        margin: 0;
        position: relative;
        --mobile-left: 0px;
        --mobile-width: 0px;
        }

        .navbar-nav-custom::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: var(--mobile-left, 0);
        width: var(--mobile-width, 0);
        height: 2px;
        background-color: #E60013;
        transition: all 0.2s ease-out;
        }

        .navbar-nav-custom li {
        width: auto;
        flex-shrink: 0;
        height: 50px;
        }

        .navbar-nav-custom a {
        width: auto;
        padding: 0 8px;
        font-size: 0.85rem;
        white-space: nowrap;
        height: 50px;
        display: flex;
        align-items: center;
        transition: color 0.3s ease;
        }

        .navbar-nav-custom a.active {
        color: #333333;
        }

        .hero-wrapper {
        width: 100%;
        }

        .hero-bg {
        height: 150px;
        min-height: 150px;
        }

        .hero-content {
        width: 90%;
        max-width: 100%;
        height: 150px;
        min-height: 150px;
        flex-direction: row;
        padding: 0 35px 0 35px;
        gap: 15px;
        align-items: flex-end;
        justify-content: space-between;
        transform: translateX(-50%);
        left: 50%;
        top: 0;
        }

        .hero-text {
        width: 60%;
        height: auto;
        text-align: left;
        flex-shrink: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-self: center;
        }

        .hero-text h1 {
        width: 100%;
        font-size: 20px;
        line-height: 26px;
        margin: 0 0 6px 0;
        }

        .hero-text p {
        width: 100%;
        font-size: 13px;
        line-height: 18px;
        }

        .hero-image {
        width: 35%;
        height: auto;
        flex-shrink: 0;
        align-items: flex-end;
        align-self: flex-end;
        }

        .hero-image img {
        width: 100%;
        height: auto;
        max-height: 140px;
        object-fit: contain;
        display: block;
        }

        .content-section {
        padding: 40px 10px;
        }

        .section-inner {
        width: 100%;
        padding: 0 10px;
        box-sizing: border-box;
        }

        .cards-container {
        width: 100%;
        max-width: 900px;
        }

        .cards-container > div {
        width: 100% !important;
        max-width: 900px;
        height: auto !important;
        min-height: 376px;
        padding: 18px 16px 10px 16px;
        }

        .card-icon {
        width: 120px !important;
        height: 134px !important;
        left: 50% !important;
        right: auto !important;
        bottom: 10px !important;
        transform: translateX(-50%) !important;
        }

        .cards-container > div ul {
        margin-bottom: 120px !important;
        margin-top: 0px !important;
        padding-bottom: 0px !important;
        }

        .cards-container > div ul li {
        margin-bottom: 0px !important;
        }

        .cards-container > div ul li:last-child {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
        }

        .section-inner h2 {
        font-size: 20px;
        }

        .section-inner p {
        font-size: 16px;
        }

        .section-inner ul {
        padding-left: 0;
        }

        .section-inner ul li {
        font-size: 16px;
        }

        .section-inner ul.square-bullets li {
        align-items: center;
        line-height: 1.6;
        }

        .section-inner ul.square-bullets li:before {
        margin-top: 0;
        line-height: 1;
        }

        .spec-image {
        width: 100% !important;
        max-width: 900px;
        margin: 20px 0 0 0 !important;
        }

        .cta-section {
        flex-direction: column;
        align-items: center;
        gap: 20px;
        text-align: center;
        }

        .cta-text {
        order: 2;
        }

        .cta-text h2 {
        margin-bottom: 8px;
        }

        .kakao-button {
        width: auto;
        order: 1;
        }

        .cta-button {
        margin: 24px auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: 60px !important;
        height: auto !important;
        padding: 16px 24px !important;
        line-height: 1.4 !important;
        overflow: visible !important;
        box-sizing: border-box !important;
        }

        .footer {
        padding: 30px 0;
        }

        .footer-inner {
        width: 100%;
        padding: 0 20px;
        box-sizing: border-box;
        }

        .footer-top {
        display: none;
        }

        .footer-mobile {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        }

        .footer-mobile .footer-logo {
        display: flex;
        align-items: center;
        gap: 6px;
        }

        .footer-mobile .footer-logo img {
        width: 18px;
        height: 18px;
        }

        .footer-mobile .footer-logo-text {
        font-size: 14px;
        color: #000000;
        font-weight: 300;
        }

        .footer-mobile .footer-logo-text .bold {
        font-weight: 700;
        }

        .footer-mobile .footer-logo-text .regular {
        font-weight: 300;
        }

        .footer-mobile .footer-social {
        display: flex;
        gap: 12px;
        }

        .footer-mobile .footer-social a {
        width: 32px;
        height: 32px;
        background-color: #000000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        }

        .footer-mobile .footer-social a:hover {
        background-color: #333333;
        }

        .footer-mobile .footer-social img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        }

        .footer-mobile .footer-nav {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, auto);
        gap: 12px 20px;
        justify-items: center;
        }

        .footer-mobile .footer-nav a {
        color: #000000;
        text-decoration: none;
        font-size: 12px;
        font-weight: 300;
        text-align: center;
        }

        .footer-mobile .footer-nav a:hover {
        color: #666666;
        }

        .footer-mobile .footer-info {
        font-size: 9px;
        font-weight: 300;
        line-height: 1.6;
        color: #666666;
        text-align: center;
        margin-top: 10px;
        }

        .footer-mobile .footer-info p {
        margin: 0 0 4px 0;
        }

        .review-card {
        width: 100%;
        max-width: 900px;
        padding: 14px;
        }

        .review-rating-text {
        font-size: 11px;
        }

        .review-author {
        font-size: 11px;
        }

        .review-body {
        font-size: 11px;
        }
        }

        @media (max-width: 480px) {
        .promo-banner {
        padding: 10px 10px;
        text-align: center;
        }

        .promo-banner a {
        font-size: 0.75rem;
        display: block;
        width: 100%;
        text-align: center;
        line-height: 1.6;
        }

        .navbar-custom {
        padding: 0 2px;
        justify-content: center;
        }

        .navbar-nav-custom {
        justify-content: center;
        }

        .navbar-nav-custom a {
        padding: 0 8px;
        font-size: 0.75rem;
        }

        .hero-bg {
        height: 150px;
        min-height: 150px;
        }

        .hero-content {
        width: 95%;
        height: 150px;
        min-height: 150px;
        padding: 0 30px 0 30px;
        gap: 12px;
        align-items: flex-end;
        }

        .hero-text {
        width: 60%;
        align-self: center;
        }

        .hero-text h1 {
        font-size: 18px;
        line-height: 24px;
        margin: 0 0 4px 0;
        }

        .hero-text p {
        font-size: 11px;
        line-height: 16px;
        }

        .hero-image {
        width: 35%;
        align-self: flex-end;
        }

        .hero-image img {
        max-height: 140px;
        }

        .content-section {
        padding: 40px 5px;
        }

        .section-inner {
        padding: 0 5px;
        }

        .cta-button {
        margin: 24px auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-height: 60px !important;
        height: auto !important;
        padding: 16px 24px !important;
        line-height: 1.4 !important;
        overflow: visible !important;
        box-sizing: border-box !important;
        }

        .section-inner h2 {
        font-size: 18px;
        }

        .section-inner p {
        font-size: 14px;
        }

        .section-inner ul li {
        font-size: 14px;
        }

        .section-inner ul.square-bullets li {
        align-items: center;
        line-height: 1.6;
        }

        .section-inner ul.square-bullets li:before {
        margin-top: 0;
        line-height: 1;
        }

        .cards-container {
        width: 100%;
        max-width: 900px;
        }

        .cards-container > div {
        width: 100% !important;
        max-width: 900px;
        height: auto !important;
        min-height: 300px;
        padding: 16px 14px 8px 14px;
        margin: 20px auto 0 !important;
        }

        .card-icon {
        width: 100px !important;
        height: 112px !important;
        left: 50% !important;
        right: auto !important;
        bottom: 8px !important;
        transform: translateX(-50%) !important;
        }

        .cards-container > div ul {
        margin-bottom: 100px !important;
        margin-top: 0px !important;
        padding-bottom: 0px !important;
        }

        .cards-container > div ul li {
        margin-bottom: 0px !important;
        }

        .cards-container > div ul li:last-child {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
        }

        .spec-image {
        width: 100% !important;
        max-width: 900px;
        margin: 16px 0 0 0 !important;
        }

        .footer-nav {
        grid-template-columns: 1fr;
        }

        .review-card {
        width: 100%;
        max-width: 900px;
        padding: 14px;
        }

        .review-stars-container {
        flex-wrap: wrap;
        gap: 2px;
        }

        .review-rating-text {
        font-size: 11px;
        margin-left: 2px;
        }

        .review-author {
        font-size: 11px;
        flex-wrap: wrap;
        }

        .review-body {
        font-size: 11px;
        }
        }
    </style>
</head>
<body id="top">
    <header class="promo-banner">
        <a href="https://www.pweng.net/level-test.php" class="level-test-link" target="_blank">
            무료 레벨테스트 받고 강사평가 남기면 <span class="highlight">1,000</span>원 쿠폰 즉시 적립! <span class="arrow">&gt;</span>
        </a>
    </header>

    <nav class="navbar-custom">
        <ul class="navbar-nav-custom">
            <li><a href="#top" class="active">스피킹 성공공식</a></li>
            <li><a href="#intro">매일영챌린지 소개</a></li>
            <li><a href="#faq">매일영챌린지 FAQ</a></li>
        </ul>
    </nav>

    <section class="hero-section">
        <div class="hero-wrapper">
            <img src="{{ asset('landing/lp-gen-img-1-1.png') }}" alt="Hero background" class="hero-bg">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>2026년 영어 스피킹<br>잘하는 방법</h1>
                    <p>매일영 챌린지로 완성하는<br>실전 영어 말하기</p>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('landing/lp-gen-img-1-0.png') }}" alt="매일영 챌린지">
                </div>
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>어떻게 해야</h2>
            <p>영어를 "진짜로" 실력으로 만들 수 있을까? <br> 우리는 이 질문에 대해 오랫동안 생각후 아래와 같은 결론에 도달했습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>먼저 말씀드립니다</h2>
            <p>설레는 문구에 끌려 "이거 하면 한 달 만에 영어 된다" 같은 이야기를 기대하고 오셨다면 <br> 아쉽게도 이 내용은 실망스러울 수 있습니다.</p>
            <p>저희는 있는 그대로만 이야기합니다. 매일영 챌린지를 했다고 해서</p>
            <ul>
                <li>한 달 만에 원어민처럼 말하게 된다거나</li>
                <li>공부 안 해도 자동으로 영어가 느는 일은</li>
            </ul>
            <p>절대 일어나지 않습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>지금부터 보여드리는 것이 현실입니다</h2>
            <p>매일영 챌린지를 통해 3~6개월 이상 꾸준히 참여한 학습자 중</p>
            <ul class="square-bullets">
                <li data-number="1">말문이 트이기 시작했다</li>
                <li data-number="2">영어 문장이 입에서 자동으로 나온다</li>
                <li data-number="3">예전보다 영어가 덜 무섭다</li>
            </ul>
            <p>라고 말하는 사례는 분명히 나옵니다. 하지만 이런 변화는 하루아침에, 아무 노력 없이 생기지 않습니다.</p>

            @php
            $reviews = [
                ['rating' => '10점[수업교재 - Making Grammar Incredibly Fun 1]', 'author' => '정시훈 (2025-08-11)', 'label' => '레벨테스트', 'body' => '저희아이가 전화영어 해주고싶어 레벨테스트신청했어요 선생님께서 질문도 해주시고 테스트후에 문법설명해주셔서 도움이 되어요 저희아이가 고등학생인데 계속 수업하도록 얘기하고 있어요 선생님감사합니다^^'],
                ['rating' => '10점[수업교재 - Senior Lower Intermediate 1]', 'author' => '전서연 (2025-08-05)', 'label' => '수업 후기', 'body' => '대화가 잘 통해서 좋았고 꼼꼼하게 틀린 말에 대해 고쳐주셔서 도움이 많이 되고 있습니다~'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '손영희 (2025-09-22)', 'label' => '수업 후기', 'body' => '선생님이 수업을 많이 해보신 것 같은 느낌이 드네요. 자연스럽게 잘 이끌어주시고 주제 채택이나 어법 교정이 좋았습니다.'],
                ['rating' => '10점[수업교재 - Business Pattern English 1]', 'author' => '전연우 (2025-08-05)', 'label' => '수업 후기', 'body' => '선생님이 에너지가 많으셔서 활기찬 느낌이라 아침 수업인데도 힘들지 않고 수업하기 좋습니다.'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '이인호 (2025-06-26)', 'label' => '수업 후기', 'body' => '선생님께서 경험이 풍부하신 것 같아 수업이 매우 만족스러웠습니다. 수업이 체계적으로 잘 구성되어 있었고, 학생의 수준과 반응에 따라 유연하게 수업을 이끌어 가는 능력이 인상적이었습니다.'],
                ['rating' => '10점[수업교재 - Senior Lower Intermediate 1]', 'author' => '이현준 (2025-04-01)', 'label' => '수업 후기', 'body' => '발음이 굉장히 좋아서 듣는데 문제가 없었습니다.'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '류은경 (2024-09-10)', 'label' => '수업 후기', 'body' => '항상 질문거리도 던져주시고 많이 영어 뱉어볼 수 있도록 노력해주셔서 감사드려요!'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '류은정 (2024-09-04)', 'label' => '수업 후기', 'body' => '발음 교정도 즉각적으로 해주시고, 한국어에 대한 이해도가 높으신지 제가 하고 싶은 말을 잘 캐치하셔서 영어로 말씀해주십니다 덕분에 수업이 매우 만족스럽습니다.'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '김선아 (2024-03-21)', 'label' => '레벨테스트', 'body' => '친절한 선생님의 말투와 적극적인 호응?태도? 감사했습니다. 많이 떨렸는데 배려해주셔서 감사해요 덕분에 편하게 얘기할 수 있었어요.'],
                ['rating' => '10점[수업교재 - Free Talking 1]', 'author' => '양예은 (2023-07-11)', 'label' => '레벨테스트', 'body' => '선생님이 아주 편안하게 진행해주시면서 또 테스트를 해야할 때는 전문적으로 해주시더라구요. 시간분배를 아주 적절히 잘해주셔서 마냥 수다만 떠는 것이 아니라 테스트까지 즐겁게 마쳤습니다.'],
                ['rating' => '10점[수업교재 - NEWSPAPER (SENIOR)]', 'author' => '김수지 (2023-03-17)', 'label' => '수업 후기', 'body' => '영자신문 수업 신청해서 어느덧 12차 수업이네요! 홈페이지의 기사 고리 질문이 아니라, 강사님의 주제에 대해 다양한 질문도 해주시고 제 표현에 어색한 부분이 있다면 더 자연스러운 표현으로 말씀해주셔서 일부러 따라해보고 노력하고 있습니다.'],
                ['rating' => '10점[수업교재 - Time To Debate Intermediate 1]', 'author' => '강서영 (2025-11-06)', 'label' => '수업 후기', 'body' => '선생님 너무 좋아요 ㅎㅎ 3개월 수업하고 더 끊어서 하는 중입니다! 제가 좀 느려도 잘 들어주시고 제가 무슨 말 하려는지 아시고 바로바로 좋은 어휘로 고쳐주세요! 늘 너무 감사해요.'],
            ];
            @endphp

            @foreach($reviews as $review)
            <div class="review-card">
                <div class="review-stars-container">
                    <i class="bi bi-star-fill review-star"></i>
                    <i class="bi bi-star-fill review-star"></i>
                    <i class="bi bi-star-fill review-star"></i>
                    <i class="bi bi-star-fill review-star"></i>
                    <i class="bi bi-star-fill review-star"></i>
                    <span class="review-rating-text">{{ $review['rating'] }}</span>
                </div>
                <div class="review-author">
                    {{ $review['author'] }}
                    <span class="review-label-pill">{{ $review['label'] }}</span>
                </div>
                <div class="review-body">
                    {{ $review['body'] }}
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>그렇다면 평균적인 변화는 어떨까요?</h2>
            <p>매일영 챌린지는 '기적 같은 성과'를 약속하지 않습니다. 대신,</p>
            <ul class="square-bullets">
                <li data-number="1">매일 영어에 노출되는 근육</li>
                <li data-number="2">말하지 않을 수 없는 환경</li>
                <li data-number="3">틀린 표현이 바로 교정되는 루틴</li>
            </ul>
            <p>을 통해 많은 참여자들이 공통적으로 도달하는 변화를 만듭니다.</p>

            <div class="video-wrapper">
                <iframe
                    src="https://www.youtube.com/embed/bNwXm93di54"
                    title="Video class cut"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>"완전 초보인데도 가능한가요?"</h2>
            <p>가장 많이 받는 질문입니다. "영어를 거의 안 해봤는데 따라갈 수 있을까요?" <br> "문법도 약하고 말도 안 나오는데 괜찮을까요?"</p>
            <p>그래서 저희는 말이 아니라 구조를 공개합니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>매일영 챌린지는 이런 방식입니다</h2>
            <ul>
                <li>하루에 해야 할 영어가 명확히 정해져 있고</li>
                <li>고민할 필요 없이 바로 실행할 수 있으며</li>
                <li>혼자 하지 않도록 피드백과 관리가 붙습니다</li>
            </ul>
            <p>이 구조 때문에 의지가 약한 사람도 '안 할 수 없는 상태'가 됩니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>중요한 사실 하나</h2>
            <p>영어 공부법을 소개하는 대부분의 콘텐츠는 결과가 좋게 나온 일부 사례만 보여줍니다.<br>매일영 챌린지는 다릅니다.</p>
            <ul class="square-bullets">
                <li data-number="1">누가 중간에 포기하는지</li>
                <li data-number="2">어느 시점에서 가장 흔들리는지</li>
                <li data-number="3">언제 실력이 체감되기 시작하는지</li>
            </ul>
            <p>이 모든 데이터를 운영자 입장에서 매일 확인합니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>그래서 단언할 수 있습니다</h2>
            <p>영어 실력 향상은 대단한 무언가가 아니라 시스템 문제입니다.<br>매일영 챌린지는 "특별한 사람만 되게 만드는 프로그램"이 아닙니다.<br>누구나 따라올 수 있도록 영어를 생활 루틴으로 설계한 도구입니다.</p>
            <a href="https://www.pweng.net/level-test.php" class="cta-button level-test-link" target="_blank">무료레벨테스트 신청하기</a>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>매일영 챌린지는 무엇인가요?</h2>
            <p>매일영 챌린지는 단순한 학습 영상이나 수업도, 혼자 하는 공부 프로그램도 아닙니다.<br>매일 영어를 쓰게 만드는 운영 시스템입니다.</p>
            <ul>
                <li>매일 수행하는 영어 말하기 과제</li>
                <li>회화 중심 수업과 인터뷰 실전 말하기</li>
                <li>강사의 직접 교정 피드백</li>
                <li>틀린 문장을 다시 말하게 만드는 복습 구조</li>
                <li>스스로 공부하지 않아도 굴러가는 루틴 설계</li>
            </ul>
            <img src="{{ asset('landing/sect-09-01.png') }}" alt="" class="spec-image">
            <img src="{{ asset('landing/sect-09-02.png') }}" alt="" class="spec-image">
            <img src="{{ asset('landing/sect-09-03.png') }}" alt="" class="spec-image">
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>누구에게 맞지 않을까요</h2>
            <p>아래에 해당된다면 매일영 챌린지는 맞지 않습니다.</p>
            <ul class="square-bullets">
                <li data-number="1">아무 노력 없이 영어가 늘길 바라는 경우</li>
                <li data-number="2">시작만 하다 말 가능성이 높은 경우</li>
                <li data-number="3">지적받는 것을 불편해하는 경우</li>
                <li data-number="4">매일 20~30분도 투자하기 싫은 경우</li>
            </ul>
            <p>이런 경우 시간과 비용이 모두 아깝습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>반대로 이런 분께 맞습니다</h2>
            <ul>
                <li>영어를 몇 번이나 포기해봤던 분</li>
                <li>학원&middot;인강을 들어도 느는 게 없었던 분</li>
                <li>이번엔 진짜 습관으로 만들고 싶다는 분</li>
            </ul>
            <p>매일영 챌린지는 이런 분들을 위해 만들어졌습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>매일영 챌린지의 목표는 단 하나입니다</h2>
            <p>영어를 '공부'에서 '일상'으로 바꾸는 것<br>말을 안 할 수 없고 안 보면 껄끄럽고 하루라도 빠지면 어색해지는 상태<br>그 상태까지 가도록 모든 구조가 설계되어 있습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>지금 필요한 건</h2>
            <p>더 좋은 교재도, 더 비싼 수업도 아닙니다.<br>매일 하게 만드는 구조입니다.</p>
        </div>
    </section>

    <section id="intro" class="content-section" style="background-color: #333333; height: 80px; padding: 0; text-align: center;">
        <div class="section-inner">
            <h2 style="color:white; margin-bottom: 0;">매일영 챌린지 소개</h2>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>누구나 영어를 잘할 수 있나요?</h2>
            <p>저희는 수많은 학습자를 지켜보며 분명히 알게 된 사실이 있습니다.<br>영어 공부는 누구에게나 같은 방식으로 통하지 않는다는 점입니다.<br>아래에 해당된다면, 솔직히 말씀드려 이 학습 방식은 신중히 고려하셔야 할 가능성이 높습니다.<br>지금부터 자칫 영어 드림을 깨뜨릴 수 있는 5가지 말씀을 드리겠습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>1. 이미 영어로 소통&middot;업무&middot;생활이 완성된 분이라면</h2>
            <p>이미 영어로 업무를 처리하고, 해외 커뮤니케이션에 전혀 문제가 없다면<br>저희가 도움드릴 수 있는 영역은 많지 않습니다.<br>이 과정은 아직 영어가 장벽으로 느껴지는 분들을 위한 훈련입니다.</p>
            <a href="https://www.pweng.net/level-test.php" class="cta-button level-test-link" target="_blank">무료레벨테스트 신청하기</a>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>2. 자기 객관화가 되지 않는다면</h2>
            <p>"영어는 다 아는데 말이 안 나온다"<br>"예전에 공부는 다 해봤다"<br>이런 상태에서 본인의 위치를 정확히 보지 못하면<br>학습 방식을 받아들이는 데 너무 오랜 시간이 걸립니다.<br>단어를 안다고 회화가 되는 것은 아닙니다.<br>문법을 본 적이 있다고 말이 트이지도 않습니다.<br>이 차이를 인정하지 못하면 몇 개월이 그대로 제자리입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>3. 거의 공부하지 않았지만 단기간에 유창해지길 바란다면</h2>
            <p>영어를 두세 달 안에 자유자재로 하겠다는 기대는 현실적인 목표가 아닙니다.<br>일부 빠른 성과 사례가 있다고 해서<br>"나도 곧 그렇게 될 것"이라 생각하면<br>반드시 중간에 포기하게 됩니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>4. 제로베이스라면 필요한 시간은 명확합니다</h2>
            <p>학교 영어 이후 거의 사용하지 않았던 제로베이스 기준으로<br>영어 말하기 기초 체력을 만들기까지는<br>최소 30분~1시간 투자 기준 약 9~12개월이 필요합니다.</p>
            <ul>
                <li>3개월: 틀과 문장 구조 적응</li>
                <li>6개월: 기본 문장 끌어내기 가능</li>
                <li>9개월 이후: 말이 이어지기 시작</li>
            </ul>
            <p>대부분 포기하는 시점은 2~3개월입니다.<br>그러나 하루 30분도 투자하지 않고<br>영어 실력이 늘기를 기대하는 것은 비현실적입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>5. 단기 요령이나 팁만 원한다면 맞지 않습니다</h2>
            <p>이 과정은 시험 요령이나 암기법 중심이 아닙니다.<br>계속 사용할 수 있는 영어 근육을 만드는 방식입니다.<br>빠른 점수 상승이나 단기 성과만을 원한다면<br>이 방식은 답답하게 느껴질 수 있습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>그렇다면, 누가 이 영어 학습에 맞을까요?</h2>
            <ul class="square-bullets">
                <li data-number="&#10003;">매일 조금씩이라도 영어를 접할 수 있는 사람</li>
                <li data-number="&#10003;">유창함보다 "계속 말하는 힘"을 만들고 싶은 사람</li>
                <li data-number="&#10003;">영어를 공부가 아니라 습관으로 만들고 싶은 사람</li>
            </ul>
            <p>이런 분들에게 필요한 것은<br>테크닉이 아니라 매일 반복 가능한 구조입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>그래서, 매일영 챌린지입니다</h2>
            <p>매일영 챌린지는<br>영어를 짧게 배워주겠다고 약속하지 않습니다.<br>대신 매일 영어를 쓰게 만드는 환경을 만듭니다.</p>
            <ul>
                <li>하루 분량이 정해진 학습 구조</li>
                <li>고민하지 않아도 따라갈 수 있는 루틴</li>
                <li>포기하지 않도록 설계된 난이도</li>
            </ul>
            <p>영어 실력이 느는 사람들의 공통점은 하나입니다.<br>매일 영어를 하는 사람이라는 것.</p>
        </div>
    </section>

    <section id="faq" class="content-section" style="background-color: #333333; height: 80px; padding: 0; text-align: center;">
        <div class="section-inner">
            <h2 style="color:white; margin-bottom: 0;">매일영챌린지 FAQ</h2>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>의지는 필요 없습니다. 매일영의 '밀착 케어'이 당신의 입을 열어드립니다!</h2>
            <p>"혼자 하면 작심삼일이지만, 나를 전담 마크하는 강사가 있다면 달라집니다."</p>
            <h2>[매일영 챌린지 3단계 스피킹 루틴]</h2>
            <p>매일영은 단순히 수다를 떠는 원어민 친구를 매칭해드리는 서비스가 아닙니다. 공부를 안 할 수 없게 설계된 시스템으로 당신의 실력을 강제로 끌어올립니다.</p>

            <div class="cards-container">
                <div style="width: 900px; height: 376px; margin: 0 auto; background-color: #fff; border-radius: 16px; padding: 32px; position: relative; text-align: left;">
                    <div class="card-number">01</div>
                    <h2>"녹음 인증" — 안 하면 수업 참여 불가</h2>
                    <p>수업 전, 온라인 교재의 핵심 문장을 직접 읽고 녹음하여 제출해야 합니다. 미션을 완료해야만 그날의 수업에 참여할 수 있는 자격이 주어집니다.</p>
                    <ul>
                        <li>실행 방식: 전담 강사가 카카오톡으로 직접 숙제를 내주고, 학습자는 'Practice' 섹션 문장 녹음본을 강사에게 제출합니다.</li>
                        <li>강제 장치: 나만을 기다리는 강사의 1:1 실시간 체크! '보는 공부'를 '말하는 공부'로 바꾸는 가장 확실한 강제성입니다.</li>
                    </ul>
                    <img src="{{ asset('landing/ico-spec-1.png') }}" alt="" class="card-icon">
                    <div style="position: absolute; top: 25px; left: 80px; transform: translateX(-50%); width: 12px; height: 12px; border-radius: 50%; background-color: #9BB3FF; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 100px; right: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #F3A268; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 160px; left: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #34E7A5; opacity: 0.3;"></div>
                </div>
                <div style="width: 900px; height: 376px; margin: 24px auto 0; background-color: #fff; border-radius: 16px; padding: 32px; position: relative; text-align: left;">
                    <div class="card-number">02</div>
                    <h2>"외워 뱉기" — 교재를 덮어야 시작되는 수업</h2>
                    <p>수업이 시작되면 교재에 의존할 수 없습니다. 강사는 교재 내용을 바탕으로 기습 질문을 던지고, 학습자는 오직 암기한 내용을 바탕으로 즉각 대답해야 합니다.</p>
                    <ul>
                        <li>실행 방식: "교재 15페이지 세 번째 문장, '회의를 미루다'를 넣어서 과거형으로 말해보세요"</li>
                        <li>훈련 효과: 텍스트 의존도를 0%로 낮춰, 전화가 오기 전 5분 동안 인생에서 가장 집중력 높은 '몰입의 시간'을 갖게 됩니다.</li>
                    </ul>
                    <img src="{{ asset('landing/ico-spec-2.png') }}" alt="" class="card-icon">
                    <div style="position: absolute; top: 25px; left: 80px; transform: translateX(-50%); width: 12px; height: 12px; border-radius: 50%; background-color: #9BB3FF; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 100px; right: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #F3A268; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 160px; left: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #34E7A5; opacity: 0.3;"></div>
                </div>
                <div style="width: 900px; height: 376px; margin: 24px auto 0; background-color: #fff; border-radius: 16px; padding: 32px; position: relative; text-align: left;">
                    <div class="card-number">03</div>
                    <h2>"강제 롤플레이" — 문장을 상황으로 바꾸는 시간</h2>
                    <p>교재 속 딱딱한 문장들을 실제 대화로 바꿉니다. 강사와 함께 설정된 상황 속으로 들어가 배운 표현을 완벽히 써먹을 때까지 훈련은 계속됩니다.</p>
                    <ul>
                        <li>실행 방식: "제가 점원이고 학생분이 손님입니다. 교재의 예약 문장을 활용해 대화를 시작하세요!"</li>
                        <li>훈련 효과: 글로만 보던 문장이 실제 상황에서 '살아있는 언어'로 변환됩니다. 1:1 수업이기에 틀린 발음과 뉘앙스까지 실시간으로 완벽 교정받습니다.</li>
                    </ul>
                    <img src="{{ asset('landing/ico-spec-3.png') }}" alt="" class="card-icon">
                    <div style="position: absolute; top: 25px; left: 80px; transform: translateX(-50%); width: 12px; height: 12px; border-radius: 50%; background-color: #9BB3FF; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 100px; right: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #F3A268; opacity: 0.3;"></div>
                    <div style="position: absolute; top: 160px; left: 50px; width: 10px; height: 10px; border-radius: 50%; background-color: #34E7A5; opacity: 0.3;"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>매일영 챌린지는 매일 참여해야 하나요?</h2>
            <p>네, 매일 참여하는 것을 전제로 설계된 프로그램입니다.<br>다만 하루 학습 분량은 20분 내외로, 직장인&middot;학생 모두 병행이 가능하도록 구성되어 있습니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>실시간 수업이나 오프라인 수업도 포함되나요?</h2>
            <p>아니요.</p>
            <p>매일영 챌린지는 오프라인 수업이나 실시간 강의 중심 프로그램이 아닙니다. <br> 이 과정의 목적은 강사나 클래스가 없어도<br>혼자서 영어 스피킹을 지속할 수 있는 힘을 만드는 것입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>영어 회화 초보자도 참여할 수 있나요?</h2>
            <p>네, 가능합니다.</p>
            <p>매일영 챌린지는 영어로 거의 말해본 적 없는 스피킹 제로베이스 학습자를 기준으로 설계되었습니다.</p>
            <ul class="square-bullets">
                <li data-number="1">문법을 알긴 하는데 말이 안 나오는 분</li>
                <li data-number="2">단어만 외우다 끝났던 분</li>
                <li data-number="3">영어 공부를 다시 시작하고 싶은 분</li>
            </ul>
            <p>이런 분들을 위한 구조입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>강사가 개인적으로 피드백이나 컨설팅을 해주나요?</h2>
            <p>매일영 챌린지는 개인 맞춤 컨설팅이나 1 : 1 코칭을 제공하지 않습니다. 대신,</p>
            <ul class="square-bullets">
                <li data-number="1">대부분의 학습자가 막히는 지점을 기준으로 설계된 콘텐츠</li>
                <li data-number="2">스스로 점검할 수 있는 체크 포인트</li>
                <li data-number="3">포기하지 않도록 설계된 루틴</li>
            </ul>
            <p>을 통해 자기 주도형 스피킹 훈련을 목표로 합니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>일정이 불규칙한데 참여할 수 있을까요?</h2>
            <p>가능합니다.</p>
            <p>매일영 챌린지는 고정 시간 출석이나 예약 수업이 없습니다. 하루 중 본인이 가능한 시간에 학습 콘텐츠를 확인하고<br>스피킹 과제를 수행하면 됩니다. 단, 습관을 만들기 위해서는 매일 최소 20분 이상은 반드시 확보하는 것을 권장드립니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>매일영 챌린지의 목표는 무엇인가요?</h2>
            <p>매일영 챌린지의 목표는 단순합니다.</p>
            <ul class="square-bullets">
                <li data-number="&#10003;">영어를 "공부 대상"이 아니라</li>
                <li data-number="&#10003;">매일 사용하는 도구로 만드는 것</li>
            </ul>
            <p>과정이 끝났을 때 누군가의 관리 없이도 스스로 영어 스피킹 루틴을 유지할 수 있다면 이 챌린지는 성공입니다.</p>
        </div>
    </section>

    <section class="content-section">
        <div class="section-inner">
            <h2>이런 분들께 추천합니다</h2>
            <ul>
                <li>영어 회화를 여러 번 시작했다가 포기한 분</li>
                <li>학원&middot;강의 중심 학습이 맞지 않았던 분</li>
                <li>짧은 시간이라도 매일 영어를 쓰고 싶은 분</li>
            </ul>
            <p>영어 스피킹은 결국엔 '구조와 반복'이 답입니다.<br>매일영 챌린지는 그 구조를 대신 만들어놓은 것입니다.</p>
        </div>
    </section>

    {{-- ========== 무료레벨테스트 CTA ========== --}}
    <section class="content-section" style="text-align: center;">
        <div class="section-inner">
            <h2>지금 바로 시작하세요</h2>
            <p>무료 레벨테스트로 나의 영어 실력을 확인해보세요.</p>
            <a href="https://www.pweng.net/level-test.php" class="cta-button level-test-link" target="_blank">무료레벨테스트 신청하기</a>
        </div>
    </section>

    {{-- ========== 카카오 문의 ========== --}}
    <section class="content-section">
        <div class="section-inner cta-section">
            <div class="cta-text">
                <h2>궁금한 점이 있으신가요?</h2>
                <p>문의해 주시면 고민을 함께 해결해 드릴게요!</p>
            </div>
            <a href="https://pf.kakao.com/_elxhdl" target="_blank" class="kakao-button">
                <img src="{{ asset('landing/KakaoTalk_logo.png') }}" alt="KakaoTalk">
                카카오 문의
            </a>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-left">
                    <div class="footer-info">
                        <p>와이즈에듀케이션아이(주) 사이트명: 파워잉글리쉬 대표이사 전상현</p>
                        <p>사업자등록번호: 217-81-44736 통신판매신고번호: 2014-서울도봉-0233호</p>
                        <p>서울본사: 서울시 노원구 한글비석로 245 두타빌 B동 7층 713호</p>
                        <p>대표번호: 1688-8672 개인정보관리 책임자: 안희영 [powerenglish@pweng.net]</p>
                    </div>
                    <div class="footer-social">
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
                    <div class="footer-logo">
                        <img src="{{ asset('landing/pweng.png') }}" alt="PowerEnglish">
                        <div class="footer-logo-text">
                        <span class="regular">Wise Education I Co., Ltd.</span>
                        </div>
                    </div>
                </div>
                <div class="footer-right">
                    <nav class="footer-nav">
                        <a href="https://m.pweng.net/login-v2.php" class="dynamic-link" data-link-type="login">로그인</a>
                        <a href="https://m.pweng.net/me/support.php" class="dynamic-link" data-link-type="support">상담 요청</a>
                        <a href="https://m.pweng.net/faq-v2.php" class="dynamic-link" data-link-type="faq">FAQ</a>
                        <a href="https://m.pweng.net/term-of-use.php" class="dynamic-link" data-link-type="terms">이용약관</a>
                        <a href="https://m.pweng.net/privacy-policy.php" class="dynamic-link" data-link-type="privacy">개인정보 처리방침</a>
                        <a href="https://dailychallenge.co.kr/" class="dynamic-link" data-link-type="pc-version">PC버전</a>
                    </nav>
                </div>
            </div>
            <div class="footer-mobile">
                <div class="footer-logo">
                    <img src="{{ asset('landing/pweng.png') }}" alt="PowerEnglish">
                    <div class="footer-logo-text">
                        <span class="regular">Wise Education I Co., Ltd.</span>
                    </div>
                </div>
                <div class="footer-social">
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
                <nav class="footer-nav">
                    <a href="https://m.pweng.net/login-v2.php" class="dynamic-link" data-link-type="login">로그인</a>
                    <a href="https://m.pweng.net/me/support.php" class="dynamic-link" data-link-type="support">상담 요청</a>
                    <a href="https://m.pweng.net/faq-v2.php" class="dynamic-link" data-link-type="faq">FAQ</a>
                    <a href="https://m.pweng.net/term-of-use.php" class="dynamic-link" data-link-type="terms">이용약관</a>
                    <a href="https://m.pweng.net/privacy-policy.php" class="dynamic-link" data-link-type="privacy">개인정보 처리방침</a>
                    <a href="https://dailychallenge.co.kr/" class="dynamic-link" data-link-type="pc-version">PC버전</a>
                </nav>
                <div class="footer-info">
                    <p>와이즈에듀케이션아이(주) 사이트명: 파워잉글리쉬 대표이사 전상현</p>
                    <p>사업자등록번호: 217-81-44736 통신판매신고번호: 2014-서울도봉-0233호</p>
                    <p>서울본사: 서울시 노원구 한글비석로 245 두타빌 B동 7층 713호</p>
                    <p>대표번호: 1688-8672 개인정보관리 책임자: 안희영 [powerenglish@pweng.net]</p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('landing/js/main.js') }}"></script>

    <script>
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
