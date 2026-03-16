@props(['width' => '100%', 'height' => '200'])

<svg xmlns="http://www.w3.org/2000/svg" width="{{ $width }}" height="{{ $height }}" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid meet" class="svg-placeholder" style="width: 100%; max-width: 100%; height: auto; display: block; border-radius: 12px; border: 1px solid #ced4da;">
    <rect width="400" height="300" fill="#e9ecef" class="svg-placeholder-bg"/>
    <!-- Mountains -->
    <polygon points="80,240 200,120 320,240" fill="#ced4da" class="svg-placeholder-mountain"/>
    <polygon points="200,240 300,160 400,240" fill="#adb5bd" class="svg-placeholder-mountain-sm"/>
    <!-- Sun -->
    <circle cx="310" cy="100" r="35" fill="#dee2e6" class="svg-placeholder-sun"/>
    <!-- Bottom bar -->
    <rect y="240" width="400" height="60" fill="#dee2e6" class="svg-placeholder-ground"/>
    <!-- Icon -->
    <g transform="translate(170, 250)" fill="#adb5bd" class="svg-placeholder-icon">
        <path d="M0,10 L20,10 L20,30 L40,30 L40,10 L60,10 L60,40 L0,40 Z" opacity="0"/>
    </g>
    <!-- Text -->
    <text x="200" y="275" text-anchor="middle" fill="#6c757d" font-family="sans-serif" font-size="15" class="svg-placeholder-text">No Image</text>
</svg>
