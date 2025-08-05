<div x-data="gravatarHovercard()" class="gravatar-hovercard">
    <style>
        .gravatar-hovercard {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            background: #1a1a1a;
            border: 2px solid var(--color-trans-light-blue);
            position: relative;
        }

        .gravatar-hovercard__inner {
            position: relative;
        }

        .gravatar-hovercard__header-image {
            height: 80px;
            width: 100%;
            background-size: cover !important;
            background-position: center !important;
        }

        .gravatar-hovercard__header {
            padding: 1rem;
            text-align: center;
            margin-top: -52px;
            position: relative;
            z-index: 10;
        }

        .gravatar-hovercard__avatar-link {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .gravatar-hovercard__avatar {
            width: 104px;
            height: 104px;
            border-radius: 50%;
            border: 4px solid var(--color-trans-white);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .gravatar-hovercard__personal-info-link {
            text-decoration: none;
            color: inherit;
        }

        .gravatar-hovercard__name {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
            color: var(--color-trans-white);
        }

        .gravatar-hovercard__job {
            font-size: 0.875rem;
            color: var(--color-trans-light-blue);
            margin: 0 0 0.25rem 0;
        }

        .gravatar-hovercard__location {
            font-size: 0.875rem;
            color: var(--color-trans-pink);
            margin: 0;
        }

        .gravatar-hovercard__body {
            padding: 0 1rem 1rem;
        }

        .gravatar-hovercard__description {
            font-size: 0.875rem;
            line-height: 1.5;
            color: var(--color-trans-white);
            margin: 0;
            text-align: center;
        }

        .gravatar-hovercard__social-links {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding: 0 1rem 1rem;
        }

        .gravatar-hovercard__social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(91, 206, 250, 0.1);
            border: 1px solid var(--color-trans-light-blue);
            transition: all 0.2s ease;
        }

        .gravatar-hovercard__social-link:hover {
            background: var(--color-trans-light-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(91, 206, 250, 0.3);
        }

        .gravatar-hovercard__social-icon {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .gravatar-hovercard__buttons {
            display: flex;
            gap: 0.5rem;
            padding: 0 1rem 1rem;
        }

        .gravatar-hovercard__button {
            flex: 1;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 2px solid var(--color-trans-pink);
            background: transparent;
            color: var(--color-trans-pink);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .gravatar-hovercard__button:hover {
            background: var(--color-trans-pink);
            color: var(--color-trans-white);
            box-shadow: 0 0 10px var(--color-trans-pink);
        }

        .gravatar-hovercard__footer {
            padding: 1rem;
            border-top: 1px solid rgba(91, 206, 250, 0.2);
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
        }

        .gravatar-hovercard__profile-url {
            font-size: 0.75rem;
            color: var(--color-trans-light-blue);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .gravatar-hovercard__profile-link {
            font-size: 0.875rem;
            color: var(--color-trans-pink);
            text-decoration: none;
            font-weight: 500;
        }

        .gravatar-hovercard__profile-link:hover {
            color: var(--color-trans-white);
        }

        .gravatar-hovercard__drawer {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .gravatar-hovercard__drawer--open {
            opacity: 1;
            visibility: visible;
        }

        .gravatar-hovercard__drawer--closing {
            opacity: 0;
            visibility: hidden;
        }

        .gravatar-hovercard__drawer-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            cursor: pointer;
        }

        .gravatar-hovercard__drawer-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #1a1a1a;
            border: 2px solid var(--color-trans-light-blue);
            border-radius: 12px;
            min-width: 280px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .gravatar-hovercard__drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid rgba(91, 206, 250, 0.2);
        }

        .gravatar-hovercard__drawer-title {
            font-size: 1.125rem;
            font-weight: bold;
            color: var(--color-trans-white);
            margin: 0;
        }

        .gravatar-hovercard__drawer-close {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 4px;
            transition: background 0.2s ease;
        }

        .gravatar-hovercard__drawer-close:hover {
            background: rgba(91, 206, 250, 0.1);
        }

        .gravatar-hovercard__drawer-close svg {
            width: 24px;
            height: 24px;
        }

        .gravatar-hovercard__drawer-close svg path {
            fill: var(--color-trans-white);
        }

        .gravatar-hovercard__drawer-items {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .gravatar-hovercard__drawer-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(91, 206, 250, 0.1);
        }

        .gravatar-hovercard__drawer-item:last-child {
            border-bottom: none;
        }

        .gravatar-hovercard__drawer-item-icon {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .gravatar-hovercard__drawer-item-info {
            flex: 1;
        }

        .gravatar-hovercard__drawer-item-label {
            display: block;
            font-weight: 500;
            color: var(--color-trans-white);
            margin-bottom: 0.25rem;
        }

        .gravatar-hovercard__drawer-item-text {
            font-size: 0.875rem;
            color: var(--color-trans-light-blue);
        }

        .gravatar-hovercard__drawer-item-link {
            color: var(--color-trans-pink);
            text-decoration: none;
        }

        .gravatar-hovercard__drawer-item-link:hover {
            color: var(--color-trans-white);
            text-decoration: underline;
        }

        .gravatar-hovercard__profile-color {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-trans-light-blue), var(--color-trans-pink));
        }
    </style>

    <div class="gravatar-hovercard__inner">
        <div class="gravatar-hovercard__header-image" style="background: url('https://1.gravatar.com/userimage/178303899/10a630be070bfb2400f913b21aadc30f?size=1024') 50% 27% / 100% no-repeat;"></div>

        <div class="gravatar-hovercard__header">
            <a class="gravatar-hovercard__avatar-link" href="https://gravatar.com/blacksoulgem95?utm_source=hovercard" target="_blank">
                <img class="gravatar-hovercard__avatar" src="https://1.gravatar.com/avatar/f7f79dbcca6c94b0c88240cc3659eea7b197914383b478ea40cb983574d1aa86?s=256" width="104" height="104" alt="Sofia Vicedomini">
            </a>
            <a class="gravatar-hovercard__personal-info-link" href="https://gravatar.com/blacksoulgem95?utm_source=hovercard" target="_blank">
                <h4 class="gravatar-hovercard__name">Sofia Vicedomini</h4>
                <p class="gravatar-hovercard__job">EU/US/CA/UK Full-Stack Senior Software Engineer, Freelance</p>
                <p class="gravatar-hovercard__location">EMEA (Remote)</p>
            </a>
        </div>

        <div class="gravatar-hovercard__body">
            <p class="gravatar-hovercard__description">I'm Sofia Vicedomini, a dedicated software engineering consultant with a passion for building innovative, accessible solutions in a fully remote environment.</p>
        </div>

        <div class="gravatar-hovercard__social-links">
            <a class="gravatar-hovercard__social-link" href="https://gravatar.com/blacksoulgem95?utm_source=hovercard" target="_blank" data-service-name="gravatar">
                <img class="gravatar-hovercard__social-icon" src="https://s.gravatar.com/icons/gravatar.svg" width="32" height="32" alt="Gravatar">
            </a>
            <a class="gravatar-hovercard__social-link" href="https://x.com/blacksoulgem95" target="_blank" data-service-name="twitter">
                <img class="gravatar-hovercard__social-icon" src="https://s.gravatar.com/icons/x.svg" width="32" height="32" alt="X">
            </a>
            <a class="gravatar-hovercard__social-link" href="https://www.linkedin.com/in/sofiavicedomini" target="_blank" data-service-name="linkedin">
                <img class="gravatar-hovercard__social-icon" src="https://s.gravatar.com/icons/linkedin.svg" width="32" height="32" alt="LinkedIn">
            </a>
            <a class="gravatar-hovercard__social-link" href="https://tiktok.com/@blacksoulgem95" target="_blank" data-service-name="tiktok">
                <img class="gravatar-hovercard__social-icon" src="https://s.gravatar.com/icons/tiktok.svg" width="32" height="32" alt="TikTok">
            </a>
        </div>

        <div class="gravatar-hovercard__buttons">
            <button class="gravatar-hovercard__button" @click="openDrawer('contact')">Contact</button>
            <button class="gravatar-hovercard__button" @click="openDrawer('send-money')">Send money</button>
        </div>

        <div class="gravatar-hovercard__footer">
            <a class="gravatar-hovercard__profile-url" title="https://gravatar.com/blacksoulgem95" href="https://gravatar.com/blacksoulgem95?utm_source=profile-card" target="_blank">
                gravatar.com/blacksoulgem95
            </a>
            <a class="gravatar-hovercard__profile-link" href="https://gravatar.com/blacksoulgem95?utm_source=profile-card" target="_blank">
                View profile →
            </a>
        </div>

        <!-- Contact Drawer -->
        <div class="gravatar-hovercard__drawer" :class="{ 'gravatar-hovercard__drawer--open': activeDrawer === 'contact', 'gravatar-hovercard__drawer--closing': closingDrawer === 'contact' }">
            <div class="gravatar-hovercard__drawer-backdrop" @click="closeDrawer('contact')"></div>
            <div class="gravatar-hovercard__drawer-card">
                <div class="gravatar-hovercard__drawer-header">
                    <h2 class="gravatar-hovercard__drawer-title">Contact</h2>
                    <button class="gravatar-hovercard__drawer-close" @click="closeDrawer('contact')">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13.0607L15.7123 16.773L16.773 15.7123L13.0607 12L16.773 8.28772L15.7123 7.22706L12 10.9394L8.28771 7.22705L7.22705 8.28771L10.9394 12L7.22706 15.7123L8.28772 16.773L12 13.0607Z" fill="#101517"></path>
                        </svg>
                    </button>
                </div>
                <ul class="gravatar-hovercard__drawer-items">
                    <li class="gravatar-hovercard__drawer-item">
                        <img class="gravatar-hovercard__drawer-item-icon" width="24" height="24" src="https://s.gravatar.com/icons/envelope.svg" alt="">
                        <div class="gravatar-hovercard__drawer-item-info">
                            <span class="gravatar-hovercard__drawer-item-label">Contact Form</span>
                            <span class="gravatar-hovercard__drawer-item-text">
                                <a class="gravatar-hovercard__drawer-item-link" href="https://www.sofiavicedomini.me/contact" target="_blank">www.sofiavicedomini.me/contact</a>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Send Money Drawer -->
        <div class="gravatar-hovercard__drawer" :class="{ 'gravatar-hovercard__drawer--open': activeDrawer === 'send-money', 'gravatar-hovercard__drawer--closing': closingDrawer === 'send-money' }">
            <div class="gravatar-hovercard__drawer-backdrop" @click="closeDrawer('send-money')"></div>
            <div class="gravatar-hovercard__drawer-card">
                <div class="gravatar-hovercard__drawer-header">
                    <h2 class="gravatar-hovercard__drawer-title">Send money</h2>
                    <button class="gravatar-hovercard__drawer-close" @click="closeDrawer('send-money')">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 13.0607L15.7123 16.773L16.773 15.7123L13.0607 12L16.773 8.28772L15.7123 7.22706L12 10.9394L8.28771 7.22705L7.22705 8.28771L10.9394 12L7.22706 15.7123L8.28772 16.773L12 13.0607Z" fill="#101517"></path>
                        </svg>
                    </button>
                </div>
                <ul class="gravatar-hovercard__drawer-items">
                    <li class="gravatar-hovercard__drawer-item">
                        <img class="gravatar-hovercard__drawer-item-icon" width="24" height="24" src="https://s.gravatar.com/icons/link.svg" alt="">
                        <div class="gravatar-hovercard__drawer-item-info">
                            <span class="gravatar-hovercard__drawer-item-label">Ko-Fi</span>
                            <span class="gravatar-hovercard__drawer-item-text">
                                <a class="gravatar-hovercard__drawer-item-link" href="https://ko-fi.com/blacksoulgem95" target="_blank">ko-fi.com/blacksoulgem95</a>
                            </span>
                        </div>
                    </li>
                    <li class="gravatar-hovercard__drawer-item">
                        <img class="gravatar-hovercard__drawer-item-icon" width="24" height="24" src="https://s.gravatar.com/icons/link.svg" alt="">
                        <div class="gravatar-hovercard__drawer-item-info">
                            <span class="gravatar-hovercard__drawer-item-label">Revolut</span>
                            <span class="gravatar-hovercard__drawer-item-text">
                                <a class="gravatar-hovercard__drawer-item-link" href="https://revolut.me/sofiavicedomini" target="_blank">revolut.me/sofiavicedomini</a>
                            </span>
                        </div>
                    </li>
                    <li class="gravatar-hovercard__drawer-item">
                        <img class="gravatar-hovercard__drawer-item-icon" width="24" height="24" src="https://s.gravatar.com/icons/link.svg" alt="">
                        <div class="gravatar-hovercard__drawer-item-info">
                            <span class="gravatar-hovercard__drawer-item-label">bitcoin</span>
                            <span class="gravatar-hovercard__drawer-item-text">bc1q4wndp7sqy5l68yp0w67lnl96s4vug2xujjk300</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="gravatar-hovercard__profile-color" style="background: rgb(245, 169, 184);"></div>
    </div>

    <script>
        function gravatarHovercard() {
            return {
                activeDrawer: null,
                closingDrawer: null,

                openDrawer(drawerName) {
                    this.activeDrawer = drawerName;
                    this.closingDrawer = null;
                },

                closeDrawer(drawerName) {
                    this.closingDrawer = drawerName;
                    this.activeDrawer = null;

                    setTimeout(() => {
                        this.closingDrawer = null;
                    }, 300);
                }
            }
        }
    </script>
</div>
