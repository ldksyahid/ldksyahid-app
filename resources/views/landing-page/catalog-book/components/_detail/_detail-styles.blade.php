<style>
.member-profile {
    font-family: 'Poppins', sans-serif;
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1') no-repeat;
    background-size: cover;
    opacity: 0.05;
    z-index: 0;
}

.profile-photo-container {
    position: relative;
    display: inline-block;
}

.profile-photo {
    width: 250px;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
    border: 5px solid white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.profile-photo:hover {
    transform: scale(1.03);
}

.profile-badge {
    position: absolute;
    bottom: -15px;
    right: -15px;
    background: black;
    border: 2px solid white;
    border-radius: 50%;
    padding: 5px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.profile-badge img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.profile-header h1 {
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
}

.member-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.ldk-logo img {
    width: 80px;
    opacity: 0.9;
}

.profile-bio {
    font-size: 1.1rem;
    line-height: 1.7;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.card-header {
    background: linear-gradient(135deg, #006D6D 0%, #004A4A 100%) !important;
    color: white;
    border-bottom: none;
    padding: 15px 25px;
}

.card-header h3 {
    font-size: 1.3rem;
    margin: 0;
    font-weight: 600;
    color: white;
}

.card-body {
    padding: 25px;
}

.info-item {
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item strong {
    color: #008F8F;
}

.slogan-card .card-body {
    background-color: #f8f9fa;
}

.slogan-card blockquote {
    font-style: italic;
    color: #555;
    font-size: 1.1rem;
    position: relative;
}

.slogan-card blockquote::before {
    content: '"';
    font-size: 3rem;
    color: rgba(0, 143, 143, 0.1);
    position: absolute;
    left: -15px;
    top: -15px;
}

.social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.btn-instagram {
    background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 15px;
    transition: transform 0.3s ease;
}

.btn-linkedin {
    background: #0077B5;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 15px;
    transition: transform 0.3s ease;
}

.btn-instagram:hover, .btn-linkedin:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.org-info-section {
    background-color: #f9f9f9;
}

.section-title {
    color: #006D6D;
    font-weight: 700;
    position: relative;
    display: inline-block;
}

.divider {
    height: 3px;
    width: 80px;
    background: #006D6D;
    margin: 10px auto;
    border-radius: 3px;
}

.org-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;
}

.org-card-header {
    background: linear-gradient(135deg, #006D6D 0%, #004A4A 100%) !important;
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
}

.org-card-header i {
    font-size: 1.5rem;
    margin-right: 15px;
    color: white;
}

.org-card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: white;
}

.org-card-body {
    padding: 20px;
}

.vision-card .org-card-body {
    background-color: rgba(0, 143, 143, 0.05);
}

.mission-card .org-card-body {
    background-color: rgba(0, 109, 109, 0.05);
}

.org-card-body ol {
    padding-left: 20px;
}

.org-card-body li {
    margin-bottom: 8px;
}

.org-description {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    line-height: 1.8;
    color: #555;
}

@media (max-width: 992px) {
    .profile-header h1 {
        font-size: 2rem;
    }

    .profile-photo {
        width: 200px;
        height: 250px;
    }
}

@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }

    .profile-header .d-flex {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .profile-header .ldk-logo {
        margin-top: 15px;
    }

    .ldk-logo {
        display: none;
    }

    .profile-badge {
        right: 50%;
        transform: translateX(50%);
    }
}
</style>
