@props(['dark' => false])

{{-- A-4: 폼 제출 UX 개선 - 로딩 상태, 중복 클릭 방지, 인라인 검증 --}}
<form
    action="/lead"
    method="POST"
    class="w-full max-w-md mx-auto lead-form"
    novalidate
    onsubmit="return handleFormSubmit(this)"
>
    @csrf
    {{-- UTM 파라미터 + A/B 테스트 variant 히든 필드 --}}
    <input type="hidden" name="utm_source" value="{{ request('utm_source') }}">
    <input type="hidden" name="utm_medium" value="{{ request('utm_medium') }}">
    <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
    <input type="hidden" name="variant" value="{{ request('v', 'a') }}">

    <div class="space-y-3">
        <div>
            <input
                type="text"
                name="name"
                placeholder="이름"
                value="{{ old('name') }}"
                required
                minlength="2"
                class="w-full px-4 py-3 rounded-xl border {{ $dark ? 'border-white/20 bg-white/10 text-white placeholder-white/50' : 'border-gray-300 bg-white text-gray-900 placeholder-gray-400' }} focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition"
                oninput="validateName(this)"
            >
            <p class="form-error mt-1 text-sm text-red-400 hidden"></p>
            @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input
                type="tel"
                name="phone"
                placeholder="연락처 (010-0000-0000)"
                value="{{ old('phone') }}"
                required
                class="w-full px-4 py-3 rounded-xl border {{ $dark ? 'border-white/20 bg-white/10 text-white placeholder-white/50' : 'border-gray-300 bg-white text-gray-900 placeholder-gray-400' }} focus:outline-none focus:ring-2 focus:ring-[var(--color-accent)] transition"
                oninput="formatPhone(this)"
            >
            <p class="form-error mt-1 text-sm text-red-400 hidden"></p>
            @error('phone')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-start gap-2 cursor-pointer">
            <input
                type="checkbox"
                name="privacy_agree"
                required
                class="mt-0.5 w-4 h-4 rounded border-gray-300 text-[var(--color-accent)] focus:ring-[var(--color-accent)] cursor-pointer"
            >
            <span class="text-xs {{ $dark ? 'text-white/50' : 'text-gray-400' }} leading-relaxed">
                {{-- A-7: 개인정보처리방침 모달 연결 --}}
                <a href="#" onclick="openPrivacyModal(); return false;" class="underline {{ $dark ? 'text-white/70' : 'text-gray-600' }}">개인정보 수집·이용</a>에 동의합니다. (상담 목적으로만 사용, 제3자 제공 없음)
            </span>
        </label>

        <button
            type="submit"
            class="submit-btn w-full py-4 bg-[var(--color-accent)] hover:bg-[var(--color-accent-hover)] text-white font-bold text-lg rounded-xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
        >
            <span class="btn-text">지금 무료 상담 신청하기 →</span>
            <span class="btn-loading hidden">
                <svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                신청 중...
            </span>
        </button>
    </div>
</form>

<script>
// 전화번호 자동 포맷팅
function formatPhone(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value.length > 11) value = value.slice(0, 11);

    if (value.length > 7) {
        value = value.replace(/(\d{3})(\d{4})(\d{0,4})/, '$1-$2-$3');
    } else if (value.length > 3) {
        value = value.replace(/(\d{3})(\d{0,4})/, '$1-$2');
    }
    input.value = value;

    // 실시간 검증
    const errorEl = input.parentElement.querySelector('.form-error');
    if (value.length > 0 && !/^01[016789]-?\d{3,4}-?\d{4}$/.test(value)) {
        errorEl.textContent = '올바른 휴대폰 번호를 입력해주세요';
        errorEl.classList.remove('hidden');
    } else {
        errorEl.classList.add('hidden');
    }
}

// 이름 검증
function validateName(input) {
    const errorEl = input.parentElement.querySelector('.form-error');
    if (input.value.length > 0 && input.value.length < 2) {
        errorEl.textContent = '이름을 2자 이상 입력해주세요';
        errorEl.classList.remove('hidden');
    } else {
        errorEl.classList.add('hidden');
    }
}

// 폼 제출 핸들러
function handleFormSubmit(form) {
    const submitBtn = form.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    // 이미 제출 중이면 중복 방지
    if (submitBtn.disabled) return false;

    // 유효성 검사
    const name = form.querySelector('input[name="name"]').value.trim();
    const phone = form.querySelector('input[name="phone"]').value.trim();
    const privacy = form.querySelector('input[name="privacy_agree"]').checked;

    if (name.length < 2) {
        alert('이름을 2자 이상 입력해주세요');
        return false;
    }

    if (!/^01[016789]-?\d{3,4}-?\d{4}$/.test(phone)) {
        alert('올바른 휴대폰 번호를 입력해주세요');
        return false;
    }

    if (!privacy) {
        alert('개인정보 수집·이용에 동의해주세요');
        return false;
    }

    // 로딩 상태 표시
    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');

    // 폼 제출 완료 표시 (Exit Intent 방지용)
    sessionStorage.setItem('formSubmitted', '1');

    return true;
}
</script>
