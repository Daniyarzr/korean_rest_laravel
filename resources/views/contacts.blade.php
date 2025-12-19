@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="contacts-page">

    {{-- HERO --}}
    <section class="contacts-hero">
        <div class="contacts-hero__overlay"></div>

        <div class="container contacts-hero__content">
            <h1>Контакты</h1>
            <p class="text-white">Свяжитесь с нами удобным для вас способом</p>
        </div>
    </section>

    {{-- CONTACTS + MAP --}}
    <section class="section contacts-main">
        <div class="container">
            <div class="contacts-grid">

                {{-- INFO --}}
                <div class="contacts-card">
                    <h3>Наши контакты</h3>

                    <div class="contact-item">
                        <span>📍</span>
                        <div>
                            <strong>Адрес</strong>
                            <p>г. Москва, ул. Примерная, 10</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <span>📞</span>
                        <div>
                            <strong>Телефон</strong>
                            <p>
                                <a href="tel:+79990000000">
                                    +7 (999) 000-00-00
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <span>✉️</span>
                        <div>
                            <strong>Email</strong>
                            <p>
                                <a href="mailto:info@example.com">
                                    info@example.com
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <span>🕒</span>
                        <div>
                            <strong>График работы</strong>
                            <p>Пн–Пт: 09:00 – 18:00</p>
                        </div>
                    </div>
                </div>

                {{-- MAP --}}
                <div class="contacts-map">
                    <iframe
                        src="https://www.google.com/maps?q=Москва&output=embed"
                        loading="lazy">
                    </iframe>
                </div>

            </div>
        </div>
    </section>

    {{-- FORM --}}
    <section class="section contacts-form">
        <div class="container">
            <div class="form-card">
                <h3>Напишите нам</h3>

                <form method="POST" action="#">
                    @csrf

                    <div class="form-grid">
                        <input type="text" placeholder="Ваше имя" required>
                        <input type="email" placeholder="Email" required>
                        <textarea rows="4" placeholder="Сообщение" required></textarea>
                        <button class="btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
