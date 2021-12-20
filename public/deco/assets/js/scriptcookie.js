// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    autorun: true,
    delay: 0,
    current_lang: 'fr',
    theme_css: "/deco/assets/css/cookieconsent.css",
    autoclear_cookies: true,
    cookie_expiration: 365,

    gui_options: {
        consent_modal: {
            layout: 'cloud',
            position: 'bottom',
            transition: 'slide'
        },
        settings_modal: {
            layout: 'box',
            transition: 'slide'
        }
    },

    onAccept: function (cookies) {
        if (cc.allowedCategory('analytics_cookies')) {
            cc.loadScript('https://www.google-analytics.com/analytics.js', function () {
                ga('create', 'UA-XXXXXXXX-Y', 'auto'); //replace UA-XXXXXXXX-Y with your tracking code
                ga('send', 'pageview');
            });
        }
    },

    languages: {
        en: {
            consent_modal: {
                title: "Nous utilisons des cookies",
                description: "Bonjour, ce site web utilise des cookies essentiels pour assurer son bon fonctionnement; nous utilisons des cookies et d'autres technologies de suivi pour améliorer votre expérience de navigation sur notre site web, pour vous montrer un contenu personnalisé et  ciblé, pour analyser le trafic de notre site web et pour comprendre d'où viennent nos visiteurs. <a aria-label='Cookie policy' class='cc-link' href='https://mavibration.com/politique'> Lire plus </a>",
                primary_btn: {
                    text: 'Acceptez',
                    role: 'accept_all' //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Configuration',
                    role: 'settings' //'settings' or 'accept_necessary'
                }
            },
            settings_modal: {
                title: 'Cookie preferences',
                save_settings_btn: "Sauvegarder",
                accept_all_btn: "Accepter",
                cookie_table_headers: [{
                        col1: "Nom"
                    },
                    {
                        col2: "Domaine"
                    },
                    {
                        col3: "Expiration"
                    },
                    {
                        col4: "Description"
                    },
                    {
                        col5: "Type"
                    }
                ],
                blocks: [{
                    title: "Cookie usage",
                    description: "J'utilise des cookies pour assurer les fonctionnalités de base du site web et pour améliorer votre expérience en ligne. Vous pouvez choisir pour chaque catégorie d'accepter ou de refuser quand vous le souhaitez."
                }, {
                    title: "Cookies strictement nécessaires",
                    description: 'Ces cookies sont essentiels au bon fonctionnement de mon site web. Sans ces cookies, le site web ne fonctionnerait pas correctement.',
                    toggle: {
                        value: 'necessary_cookies',
                        enabled: true,
                        readonly: true
                    }
                }, {
                    title: "Cookies analytiques",
                    description: 'Ces cookies collectent des informations sur la façon dont vous utilisez le site web, les pages que vous avez visitées et les liens sur lesquels vous avez cliqué. Toutes ces données sont rendues anonymes et ne peuvent être utilisées pour vous identifier.',
                    toggle: {
                        value: 'analytics_cookies',
                        enabled: false,
                        readonly: false
                    },
                    cookie_table: [{
                            col1: '_ga',
                            col2: 'google.com',
                            col3: '2 years',
                            col4: 'description ...',
                            col5: 'Permanent cookie'
                        },
                        {
                            col1: '_gat',
                            col2: 'google.com',
                            col3: '1 minute',
                            col4: 'description ...',
                            col5: 'Permanent cookie'
                        },
                        {
                            col1: '_gid',
                            col2: 'google.com',
                            col3: '1 day',
                            col4: 'description ...',
                            col5: 'Permanent cookie'
                        }
                    ]
                }, {
                    title: "Pour plus d'informations",
                    description: 'Pour toute question relative à notre politique en matière de cookies et à vos choix, veuillez  <a class="cc-link" href="https://mavibration.com/contact">nous contactez</a>.',
                }]
            }
        }
    }
});