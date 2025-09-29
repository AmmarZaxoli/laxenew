<div id="particles-js">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #7c3aed;
            --primary-light: #8b5cf6;
            --dark: #0f172a;
            --darker: #020617;
            --light: #e2e8f0;
            --gray: #64748b;
            --lipstick: #e91e63;
            --blush: #ff80ab;
            --eyeshadow: #9c27b0;
            --mascara: #311b92;
            --foundation: #ffcc80;
            --brush: #795548;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--dark);
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .floating-cosmetic {
            position: absolute;
            font-size: 2vw;
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .cosmetic-lipstick { color: var(--lipstick); }
        .cosmetic-blush { color: var(--blush); }
        .cosmetic-eyeshadow { color: var(--eyeshadow); }
        .cosmetic-mascara { color: var(--mascara); }
        .cosmetic-foundation { color: var(--foundation); }
        .cosmetic-brush { color: var(--brush); }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            background: rgba(42, 5, 38, 0.97);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
            overflow: hidden;
            margin: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.05) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
            z-index: -1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: clamp(1.5rem, 5vw, 1.75rem);
            font-weight: 700;
            margin-bottom: 0.75rem;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-text {
            display: flex;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: clamp(1.5rem, 5vw, 1.75rem);
            font-weight: 700;
            flex-wrap: wrap;
        }

        .logo-char {
            display: inline-block;
            position: relative;
            animation: bounce 1.5s infinite ease-in-out;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo-char:nth-child(1) { color: #7c3aed; animation-delay: 0.0s; }
        .logo-char:nth-child(2) { color: #8b5cf6; animation-delay: 0.2s; }
        .logo-char:nth-child(3) { color: #a78bfa; animation-delay: 0.4s; }
        .logo-char:nth-child(4) { color: #c4b5fd; animation-delay: 0.6s; }
        .logo-char:nth-child(5) { color: #ec4899; animation-delay: 0.8s; }
        .logo-char:nth-child(6) { color: #f472b6; animation-delay: 1.0s; }
        .logo-char:nth-child(7) { color: #f9a8d4; animation-delay: 1.2s; }
        .logo-char:nth-child(8) { color: #fbcfe8; animation-delay: 1.4s; }
        .logo-char:nth-child(9) { color: #fce7f3; animation-delay: 1.6s; }
        .logo-char:nth-child(10) { color: #fecaca; animation-delay: 1.8s; }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            text-align: end;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--dark);
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: var(--dark);
            font-size: 17px;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.2);
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '⌄';
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 0.875rem;
            pointer-events: none;
        }

        select.form-control {
            appearance: none;
            padding-right: 2.5rem;
            background-color: white;
            color: var(--dark);
        }

        .login-button {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
        }

        .login-button:hover::before {
            left: 100%;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            color: #ff3e3e;
            text-align: center;
            margin: 1rem 0;
            font-weight: bold;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .login-container { padding: 2rem; }
            .logo-text { letter-spacing: 3px; }
            .floating-cosmetic { font-size: 4vw; }
        }

        @media (max-width: 480px) {
            .login-container { padding: 1.5rem; }
            .logo-text { font-size: 1.5rem; letter-spacing: 2px; }
            .login-header h1 { font-size: 1.25rem; }
            .form-control { padding: 0.75rem 0.875rem; }
            .floating-cosmetic { font-size: 6vw; }
        }

        /* Cosmetic icons */
        .cosmetic-icon {
            position: absolute;
            z-index: 0;
            pointer-events: none;
            opacity: 0.1;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }

        /* Custom shapes for cosmetics */
        .lipstick-shape {
            width: 30px;
            height: 80px;
            background: var(--lipstick);
            border-radius: 5px 5px 15px 15px;
            position: relative;
        }
        .lipstick-shape:before {
            content: '';
            position: absolute;
            top: -10px;
            left: 5px;
            width: 20px;
            height: 10px;
            background: var(--lipstick);
            border-radius: 5px 5px 0 0;
        }

        .blush-shape {
            width: 40px;
            height: 40px;
            background: var(--blush);
            border-radius: 50%;
            box-shadow: inset -5px -5px 10px rgba(0,0,0,0.1);
        }

        .mascara-shape {
            width: 15px;
            height: 60px;
            background: var(--mascara);
            border-radius: 5px;
        }
        .mascara-shape:before {
            content: '';
            position: absolute;
            top: 0;
            left: -5px;
            width: 25px;
            height: 10px;
            background: var(--mascara);
            border-radius: 5px;
        }

        .brush-shape {
            width: 40px;
            height: 8px;
            background: var(--brush);
            border-radius: 4px;
            position: relative;
        }
        .brush-shape:before {
            content: '';
            position: absolute;
            top: -20px;
            left: 5px;
            width: 6px;
            height: 20px;
            background: var(--brush);
            border-radius: 3px;
        }

        .palette-shape {
            width: 50px;
            height: 40px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .palette-shape:before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            width: 15px;
            height: 15px;
            background: var(--eyeshadow);
            border-radius: 50%;
        }
        .palette-shape:after {
            content: '';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 15px;
            height: 15px;
            background: var(--blush);
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>
    
    <div id="floatingCosmeticsContainer"></div>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo-text" style="letter-spacing: 5px">
                    <span class="logo-char">L </span>
                    <span class="logo-char">a</span>
                    <span class="logo-char">x</span>
                    <span class="logo-char">e</span>
                    <span class="logo-char">O</span>
                    <span class="logo-char">n</span>
                    <span class="logo-char">l</span>
                    <span class="logo-char">i</span>
                    <span class="logo-char">n</span>
                    <span class="logo-char">e</span>
                </div>
                <h1>تسجيل الدخول</h1>
            </div>

            <form class="login-form" wire:submit.prevent="login">
                <div class="form-group">
                    <label for="name">اختر اسمك</label>
                    <div class="select-wrapper">
                        <select class="form-control" id="name" wire:model="name" required>
                            <option value="" selected>اختر الاسم</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->name); ?>"><?php echo e($account->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">رقم السر</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="password" wire:model="password"
                            autocomplete="new-password" 
                            placeholder="أدخل کلمة المرور"
                            required
                        > 
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($error): ?>
                    <div class="error-message">
                        <?php echo e($error); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <button type="submit" class="login-button">تسجيل الدخول</button>
            </form>

            <!--[if BLOCK]><![endif]--><?php if(session('error')): ?>
                <div class="error-message">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Create floating cosmetic elements
            const container = document.getElementById('floatingCosmeticsContainer');
            const cosmeticIcons = [
                '💄', '💋', '👄', '👁️', '👁️‍🗨️', '👀', '✨', '🌸', '🌺', '🌷',
                '💅', '🧼', '🛁', '🧴', '🧽', '🪒', '🧴', '🧴', '👢', '👡', '👗', '👜'
            ];
            const cosmeticClasses = [
                'cosmetic-lipstick', 'cosmetic-blush', 'cosmetic-eyeshadow', 
                'cosmetic-mascara', 'cosmetic-foundation', 'cosmetic-brush'
            ];
            const cosmeticShapes = ['lipstick', 'blush', 'mascara', 'brush', 'palette'];
            
            const count = 40;
            
            for (let i = 0; i < count; i++) {
                // Randomly decide whether to use icon or shape
                const useShape = Math.random() > 0.5;
                
                let cosmeticElement;
                
                if (useShape) {
                    // Create a custom shape
                    cosmeticElement = document.createElement('div');
                    cosmeticElement.className = 'cosmetic-icon';
                    
                    const shapeType = cosmeticShapes[Math.floor(Math.random() * cosmeticShapes.length)];
                    const shape = document.createElement('div');
                    shape.className = shapeType + '-shape';
                    
                    // Random color class
                    const colorClass = cosmeticClasses[Math.floor(Math.random() * cosmeticClasses.length)];
                    shape.classList.add(colorClass);
                    
                    cosmeticElement.appendChild(shape);
                } else {
                    // Create an emoji icon
                    cosmeticElement = document.createElement('div');
                    cosmeticElement.className = 'floating-cosmetic ' + 
                        cosmeticClasses[Math.floor(Math.random() * cosmeticClasses.length)];
                    cosmeticElement.textContent = cosmeticIcons[Math.floor(Math.random() * cosmeticIcons.length)];
                }
                
                // Random starting position
                const startX = Math.random() * 100;
                const startY = Math.random() * 100;
                
                // Random size variation
                const size = 1 + Math.random() * 3;
                cosmeticElement.style.fontSize = `${size}rem`;
                
                if (useShape) {
                    cosmeticElement.style.width = `${size * 20}px`;
                    cosmeticElement.style.height = `${size * 20}px`;
                }
                
                // Random opacity variation
                const opacity = 0.05 + Math.random() * 0.15;
                cosmeticElement.style.opacity = opacity;
                
                // Random animation duration
                const duration = 20 + Math.random() * 40;
                
                // Random movement path
                const pathX = (Math.random() - 0.5) * 200;
                const pathY = (Math.random() - 0.5) * 200;
                
                cosmeticElement.style.left = `${startX}%`;
                cosmeticElement.style.top = `${startY}%`;
                cosmeticElement.style.animation = `floatCosmetic ${duration}s linear infinite`;
                
                // Random rotation
                const rotation = Math.random() * 360;
                cosmeticElement.style.transform = `rotate(${rotation}deg)`;
                
                // Define keyframes for this element
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes floatCosmetic {
                        0% {
                            transform: translate(0, 0) rotate(${rotation}deg);
                        }
                        25% {
                            transform: translate(${pathX}%, ${pathY}%) rotate(${rotation + 90}deg);
                        }
                        50% {
                            transform: translate(${pathX * 1.5}%, ${pathY * 1.5}%) rotate(${rotation + 180}deg);
                        }
                        75% {
                            transform: translate(${pathX}%, ${pathY}%) rotate(${rotation + 270}deg);
                        }
                        100% {
                            transform: translate(0, 0) rotate(${rotation + 360}deg);
                        }
                    }
                `;
                document.head.appendChild(style);
                
                container.appendChild(cosmeticElement);
            }

            // Particles.js configuration with softer colors
            particlesJS('particles-js', {
                "particles": {
                    "number": { "value": 50, "density": { "enable": true, "value_area": 800 } },
                    "color": { 
                        "value": ["#7c3aed", "#e91e63", "#ff80ab", "#9c27b0", "#ffcc80"] 
                    },
                    "shape": { "type": "circle" },
                    "opacity": { "value": 0.1, "random": true },
                    "size": { "value": 3, "random": true },
                    "line_linked": { 
                        "enable": true, 
                        "distance": 150, 
                        "color": "#d1c4e9", 
                        "opacity": 0.05, 
                        "width": 1 
                    },
                    "move": { 
                        "enable": true, 
                        "speed": 1, 
                        "direction": "none", 
                        "random": true,
                        "straight": false,
                        "out_mode": "out"
                    }
                },
                "interactivity": {
                    "events": {
                        "onhover": { "enable": true, "mode": "grab" },
                        "onclick": { "enable": true, "mode": "push" },
                        "resize": true
                    },
                    "modes": {
                        "grab": { "distance": 140, "line_linked": { "opacity": 0.1 } },
                        "push": { "particles_nb": 3 }
                    }
                }
            });
        });
    </script>
</body>

</html>
</div><?php /**PATH C:\Users\user\Desktop\laxe8-10 (8)\resources\views/livewire/auth/login.blade.php ENDPATH**/ ?>