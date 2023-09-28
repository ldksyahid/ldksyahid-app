<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MsDonationDataset;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Laravolt\Indonesia\Models\City;

class DonationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $donasiValues = [10000, 20000, 50000, 100000, 200000, 500000, 25000, 30000, 75000, 150000, 400000, 1000000];
        $campaigns = Campaign::all();
        $biayaAdminValues = [2500, 3000, 2000, 1000, 3500, 4000, 4500, 5000, 1500];

        $startDateTime = '2023-01-01 00:00:00';
        $endDateTime = '2023-08-19 23:59:59';

        $maxRandomEmails = 50;
        $maxDuplicateEmails = 100;

        $existingEmails = [];
        $donorsData = [];

        $domisiliCities = City::pluck('name')->all();

        $pekerjaanList = [
            'Guru', 'Dokter', 'Pengusaha', 'Karyawan', 'Mahasiswa', 'Petani', 'TNI', 'Polisi', 'Nelayan', 'Wirausaha',
            'PNS', 'Pilot', 'Pemadam Kebakaran', 'Seniman', 'Pedagang', 'Pekerja Konstruksi', 'Penyanyi', 'Penulis', 'Desainer',
            'Montir', 'Sopir', 'Koki', 'Tukang Kayu', 'Tukang Las', 'Tukang Jahit', 'Tukang Listrik', 'Pelaut', 'Peternak', 'Konsultan',
            'Arsitek', 'Pemilik Toko', 'Programmer', 'Bidan', 'Pramugari', 'Pramugara', 'Manajer', 'Marketing', 'Bendahara', 'Admin',
            'Satpam', 'Sekretaris', 'Dosen', 'Peneliti', 'Guru Les', 'Pemandu Wisata', 'Tukang Cukur', 'Petugas Kebersihan', 'Suster',
            'Pandai Besi', 'Penjaga Toko', 'Karyawan Bank', 'Akuntan', 'Farmasi', 'Quality Assurance', 'Quality Control', 'Software Engineer',
            'Content Creator', 'Animator', 'HR Specialist', 'Data Analyst', 'Translator', 'Yoga Instructor', 'Fitness Trainer',
            'Interior Designer', 'Environmental Scientist', 'Event Planner', 'Financial Advisor', 'Travel Blogger', 'Photographer',
            'Nutritionist', 'Game Developer', 'Social Worker', 'Civil Engineer', 'Robotics Engineer', 'Ethical Hacker', 'Ethnographer',
            'Meteorologist', 'Political Analyst', 'Fashion Designer', 'Archaeologist', 'Art Therapist', 'Cryptocurrency Trader',
            'Blockchain Developer', 'Ethical Hacker', 'Marine Biologist', 'Zoologist', 'Personal Chef', 'Astronomer', 'Geologist',
            'Speech Therapist', 'Neuroscientist', 'Voice Actor', 'Film Director', 'Sound Designer', 'Ethical Hacker', 'AI Researcher',
            'Astrophysicist', 'Data Scientist', 'Climate Change Analyst', 'Wildlife Biologist', 'Forensic Scientist', 'Futurist',
            'Food Scientist', 'Neonatal Nurse', 'Cybersecurity Analyst', 'Chemical Engineer', 'Environmental Engineer', 'Bioinformatician',
            'Content Creator', 'Animator', 'HR Specialist', 'Data Analyst', 'Translator', 'Yoga Instructor', 'Fitness Trainer',
            'Interior Designer', 'Environmental Scientist', 'Event Planner', 'Financial Advisor', 'Travel Blogger', 'Photographer',
            'Nutritionist', 'Game Developer', 'Social Worker', 'Civil Engineer', 'Robotics Engineer', 'Ethical Hacker', 'Ethnographer',
            'Meteorologist', 'Political Analyst', 'Fashion Designer', 'Archaeologist', 'Art Therapist', 'Cryptocurrency Trader',
            'Blockchain Developer', 'Ethical Hacker', 'Marine Biologist', 'Zoologist', 'Personal Chef', 'Astronomer', 'Geologist',
            'Speech Therapist', 'Neuroscientist', 'Voice Actor', 'Film Director', 'Sound Designer', 'Ethical Hacker', 'AI Researcher',
            'Astrophysicist', 'Data Scientist', 'Climate Change Analyst', 'Wildlife Biologist', 'Forensic Scientist', 'Futurist',
            'Food Scientist', 'Neonatal Nurse', 'Cybersecurity Analyst', 'Chemical Engineer', 'Environmental Engineer', 'Bioinformatician',
            'Urban Planner', 'Fashion Stylist', 'Interior Decorator', 'User Experience Designer', 'Public Relations Specialist',
            'Media Buyer', 'Podcaster', 'Motivational Speaker', 'Cartoonist', 'Technical Writer', 'Historian', 'Sociologist',
            'Dentist', 'Chiropractor', 'Flight Attendant', 'Event Coordinator', 'Investment Banker', 'Clinical Psychologist',
            'Physical Therapist', 'Geophysicist', 'Horticulturist', 'Automotive Mechanic', 'Physical Education Teacher',
            'Speech Language Pathologist', 'Nurse Anesthetist', 'Animal Trainer', 'Brand Manager', 'Air Traffic Controller',
            'Loan Officer', 'Museum Curator', 'Park Ranger', 'Podiatrist', 'Chief Executive Officer', 'Chief Financial Officer',
            'Chief Operating Officer', 'Chief Technology Officer', 'Chief Marketing Officer', 'Chief Creative Officer',
            'Chief Human Resources Officer', 'Chief Data Officer', 'Chief Diversity Officer', 'Chief Sustainability Officer', 'Lainnya'
        ];

        $pesanDonaturOptions = [
            "Semoga amal ibadah ini diterima dengan baik oleh Allah SWT. Doa kami untuk kesuksesan kampanye ini dan kebahagiaan bagi semua yang terlibat.",
            "Semoga kebaikan ini menjadi ladang amal yang membawa berkah dan manfaat bagi banyak orang. Terima kasih atas partisipasinya!",
            "Doa kami mengiringi setiap donasi yang diberikan. Semoga Allah SWT membalas kebaikan Anda dengan berlipat ganda.",
            "Dengan penuh harap, kami berdonasi untuk mendukung kampanye ini. Semoga langkah kecil ini membawa dampak besar.",
            "Mari kita bersama-sama berkontribusi untuk kebaikan. Semoga setiap donasi membawa perubahan positif bagi yang membutuhkan.",
            "Doa dan dukungan selalu mengiringi setiap langkah kita. Semoga donasi ini menjadi bantuan berarti bagi banyak orang.",
            "Setiap donasi memiliki makna dan harapan yang besar. Terima kasih atas peran Anda dalam kampanye ini.",
            "Dengan penuh semangat, kami turut berpartisipasi dalam kebaikan ini. Semoga Allah SWT menerima amal baik kita.",
            "Dengan senang hati kami turut berkontribusi dalam aksi kebaikan ini. Semoga Allah SWT selalu meridai langkah-langkah kita.",
            "Tidak ada donasi yang terlalu kecil jika niatnya tulus. Terima kasih atas dedikasi Anda dalam membantu sesama.",
            "Setiap doa dan donasi memiliki arti yang luar biasa. Semoga amal baik ini menjadi ladang kebahagiaan.",
            "Dalam setiap langkah kebaikan, ada cahaya yang menerangi. Terima kasih atas kesempatan berharga ini.",
            "Kami ikut berdoa agar kampanye ini sukses dan bermanfaat bagi banyak orang. Semoga amal kita diterima di sisi-Nya.",
            "Melalui tangan-tangan baik, dunia bisa menjadi tempat yang lebih baik. Semoga donasi ini membawa perubahan positif.",
            "Mari bersama-sama merangkul kebaikan. Semoga setiap sumbangsih memberikan manfaat besar bagi banyak pihak.",
            "Dengan harapan dan doa, kami mendukung kampanye ini. Semoga langkah kecil ini membawa dampak yang besar.",
            "Kami berdoa agar setiap usaha kebaikan yang kita lakukan menjadi pintu kebahagiaan di dunia dan akhirat.",
            "Dalam setiap donasi ada cinta, ada harapan, dan ada kepedulian. Terima kasih telah berbagi kebaikan.",
            "Semoga setiap tetes donasi menjadi tetes air yang menghidupkan hati yang membutuhkan. Terima kasih atas kontribusinya.",
            "Donasi adalah sinar kebaikan yang tak pernah padam. Bersama, kita mampu menerangi banyak hati.",
            "Dalam setiap langkah kebaikan, kita menciptakan jejak yang tak akan terhapus. Terima kasih atas dukungannya.",
            "Dengan donasi ini, kita memberikan peluang baru bagi mereka yang membutuhkan. Semoga Allah membalas dengan kebaikan-Nya.",
            "Kita tidak pernah tahu seberapa besar dampak yang bisa kita ciptakan dengan satu tindakan kebaikan. Terima kasih atas partisipasinya.",
            "Bersama-sama, kita mampu merubah dunia menjadi tempat yang lebih baik. Terima kasih atas donasinya!",
            "Donasi bukan hanya tentang uang, tetapi juga tentang kepedulian dan kasih sayang. Terima kasih atas peran Anda.",
            "Dengan donasi ini, kita bersama membangun jembatan kebahagiaan bagi mereka yang membutuhkan. Terima kasih atas dukungan Anda.",
            "Setiap donasi adalah doa yang kami panjatkan agar Anda selalu diberkahi dan dilindungi.",
            "Kita tidak perlu memiliki banyak untuk bisa berbagi. Setiap donasi memiliki nilai yang tak ternilai.",
            "Kemurahan hati Anda membantu mewujudkan impian dan harapan banyak orang. Terima kasih atas sumbangannya.",
            "Dalam setiap kebaikan, ada sinar kebahagiaan yang bersinar terang. Terima kasih telah menjadikan dunia ini lebih indah.",
            "Donasi adalah cermin kepedulian dan empati. Terima kasih telah berbagi semangat kebaikan.",
            "Setiap donasi adalah langkah menuju perubahan yang positif. Bersama-sama, kita mampu menginspirasi banyak orang.",
            "Dengan setiap donasi, kita membangun cerita kebaikan yang akan dikenang selamanya.",
            "Terima kasih telah berbagi harapan dan kebaikan. Semoga setiap langkahmu dipenuhi kebahagiaan.",
            "Dalam kebersamaan kita, setiap donasi menjadi tanda kasih dan kepedulian yang tulus.",
            "Dengan segala hormat dan rasa syukur, kami menerima donasi ini sebagai tanda persaudaraan dan kasih sayang.",
            "Setiap donasi adalah langkah dalam perjalanan menuju dunia yang lebih adil dan bermakna. Terima kasih atas kontribusinya.",
            "Berkat kebaikan hati Anda, dunia ini menjadi lebih hangat dan penuh harapan. Terima kasih atas donasinya.",
            "Setiap donasi adalah benih kebaikan yang akan tumbuh dan memberikan buah kebahagiaan bagi banyak orang.",
            "Dengan donasi ini, Anda telah menjadi cahaya harapan bagi yang membutuhkan. Terima kasih atas peran Anda.",
            "Setiap tetes sumbangan Anda adalah tetes air yang menghidupkan hati dan jiwa mereka yang membutuhkan.",
            "Kita tidak bisa merubah seluruh dunia, tetapi kita bisa merubah dunia bagi mereka yang membutuhkan.",
            "Donasi bukan hanya tentang memberi uang, tetapi memberi harapan dan inspirasi kepada banyak orang.",
            "Kemurahan hati Anda mengubah kegelapan menjadi cahaya bagi mereka yang sedang dalam kesulitan.",
            "Dalam setiap donasi, terdapat kebahagiaan yang tak ternilai. Terima kasih atas kebaikan Anda.",
            "Tidak ada ukuran yang tepat untuk kebaikan. Setiap donasi memiliki dampak yang luar biasa.",
            "Terima kasih telah menjadi sahabat bagi mereka yang membutuhkan melalui donasi ini.",
            "Donasi adalah bentuk kasih sayang yang dapat merubah hidup seseorang secara positif. Terima kasih telah berbagi.",
            "Kita mungkin tak bisa mengubah sejarah, tetapi kita bisa merubah masa depan melalui donasi dan kebaikan.",
            "Dalam setiap donasi, terdapat cerita kepedulian dan harapan yang membahagiakan hati.",
            "Kita tidak perlu menjadi kaya untuk bisa memberi. Setiap donasi memiliki kekayaan nilai yang tak ternilai.",
            "Dengan setiap donasi, Anda telah membantu mengubah mimpi mereka menjadi kenyataan.",
            "Terima kasih atas donasi Anda. Semoga setiap langkah yang Anda ambil diliputi berkah dan kebaikan.",
            "Setiap donasi adalah langkah menuju perubahan yang lebih baik. Bersama-sama, kita bisa menciptakan dunia yang lebih baik.",
            "Dalam dunia yang serba cepat, donasi adalah bentuk perhatian yang nyata kepada mereka yang membutuhkan.",
            "Dengan setiap donasi, Anda telah menjadi bagian dari perubahan positif yang terjadi di dunia ini.",
            "Dalam setiap kebaikan, terdapat cerita yang menginspirasi dan menyentuh hati. Terima kasih atas kontribusinya.",
            "Donasi bukan hanya tentang memberi, tetapi juga tentang merawat dan mendukung satu sama lain.",
            "Dalam kepedulian kita, terbentuklah jaringan cinta dan perhatian yang membentang ke seluruh penjuru dunia.",
            "Kemurahan hati Anda adalah obat bagi hati yang terluka dan jiwa yang gelisah.",
        ];

        $docNoCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $docNoLength = 10;

        $captchaCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-';
        $captchaLength = 400; // The length of the captcha

        for ($i = 0; $i < $maxRandomEmails; $i++) {
            $email = $faker->userName . '@gmail.com';
            $count = $faker->numberBetween(1, $maxDuplicateEmails);

            for ($j = 0; $j < $count; $j++) {
                $emailsAndCounts[] = ['email' => $email, 'count' => 1];
            }
        }

        for ($i = 0; $i < 5000 - count($emailsAndCounts); $i++) {
            $nameParts = explode(' ', $faker->name);
            $firstName = strtolower($nameParts[0]);
            $lastName = strtolower($nameParts[1] ?? '');

            $emailDomain = '@gmail.com';
            $email = $firstName . '.' . $lastName . $emailDomain;

            if (!in_array($email, $existingEmails)) {
                $existingEmails[] = $email;
                $emailsAndCounts[] = ['email' => $email, 'count' => 1];
            }
        }

        shuffle($emailsAndCounts);

        foreach ($emailsAndCounts as $data) {
            $email = $data['email'];
            $count = $data['count'];

            $emailParts = explode('@', $email);
            $nameParts = explode('.', $emailParts[0]);
            $capitalizedNameParts = array_map(function ($part) {
                return preg_replace('/[^A-Za-z ]/', '', ucfirst($part));
            }, $nameParts);

            $namaDonatur = implode(' ', $capitalizedNameParts);

            for ($i = 0; $i < $count; $i++) {
                $campaign = $campaigns->random();
                $namaMerchant = null;
                $biayaAdmin = null;
                $totalTagihan = null;
                $kodeUnik = null;
                $totalTagihan = null;

                $noTelpDonatur = '08953947' . $faker->randomNumber(5);
                $metodePembayaran = $faker->randomElement(['BANK_TRANSFER', 'EWALLET', 'RETAIL_OUTLET', 'QR_CODE']);

                $docNo = '';
                for ($j = 0; $j < $docNoLength; $j++) {
                    $docNo .= $docNoCharacters[random_int(0, strlen($docNoCharacters) - 1)];
                }

                $captcha = '';
                for ($j = 0; $j < $captchaLength; $j++) {
                    $captcha .= $captchaCharacters[random_int(0, strlen($captchaCharacters) - 1)];
                }

                $jumlahDonasi = $faker->randomElement($donasiValues);

                $paymentStatus = $faker->randomElement(['PAID', 'PAID', 'PAID', 'PENDING', 'EXPIRED']);

                if ($paymentStatus === 'EXPIRED' || $paymentStatus === 'PENDING') {
                    $metodePembayaran = null;
                } else {
                    $metodePembayaran = $faker->randomElement(['BANK_TRANSFER', 'EWALLET', 'RETAIL_OUTLET', 'QR_CODE']);
                    if ($metodePembayaran == 'BANK_TRANSFER') {
                        $namaMerchant = $faker->randomElement(['MANDIRI', 'BNI', 'BRI', 'PERMATA', 'BCA', 'SAHABAT_SAMPOERNA', 'CIMB', 'BSI', 'BJB']);
                    } elseif ($metodePembayaran == 'EWALLET') {
                        $namaMerchant = $faker->randomElement(['OVO', 'DANA', 'SHOPEEPAY', 'LINKAJA', 'ASTRAPAY', 'NEXCASH', 'JENIUSPAY']);
                    } elseif ($metodePembayaran == 'RETAIL_OUTLET') {
                        $namaMerchant = $faker->randomElement(['ALFAMART', 'INDOMARET']);
                    } elseif ($metodePembayaran == 'QR_CODE') {
                        $namaMerchant = $faker->randomElement(['QRIS']);
                    }
                    $biayaAdmin = $faker->randomElement($biayaAdminValues);
                    $totalTagihan = $jumlahDonasi;
                }

                $paymentLinkId = $faker->regexify('[a-z0-9]{20}');
                $paymentLink = "https://checkout-staging.xendit.co/v2/{$paymentLinkId}#" . strtolower($namaMerchant);

                $usia = $faker->numberBetween(18, 55);

                $domisili = $faker->randomElement($domisiliCities);

                $pekerjaan = $faker->randomElement($pekerjaanList);

                if (isset($donorsData[$email])) {
                    $noTelpDonatur = $donorsData[$email]['no_telp_donatur'];
                    $usia = $donorsData[$email]['usia'];
                    $domisili = $donorsData[$email]['domisili'];
                    $pekerjaan = $donorsData[$email]['pekerjaan'];
                } else {
                    $donorsData[$email] = [
                        'no_telp_donatur' => $noTelpDonatur,
                        'usia' => $usia,
                        'domisili' => $domisili,
                        'pekerjaan' => $pekerjaan,
                    ];
                }

                $createdDateTime = $faker->dateTimeBetween($startDateTime, $endDateTime);
                $createdDateTimeString = $createdDateTime->format('Y-m-d') . ' ' . $faker->randomElement(['08', '12', '16', '20']) . ':' . $faker->randomElement(['00', '15', '30', '45']) . ':00';



                $pesanDonatur = $faker->randomElement($pesanDonaturOptions);

                MsDonationDataset::create([
                    'id' => $faker->uuid,
                    'jumlah_donasi' => $jumlahDonasi,
                    'total_tagihan' => $totalTagihan,
                    'nama_donatur' => $namaDonatur,
                    'email_donatur' => $email,
                    'usia' => $usia,
                    'domisili' => $domisili,
                    'pekerjaan' => $pekerjaan,
                    'no_telp_donatur' => $noTelpDonatur,
                    'pesan_donatur' => $pesanDonatur,
                    'captcha' => $captcha,
                    'metode_pembayaran' => $metodePembayaran,
                    'nama_merchant' => $namaMerchant,
                    'biaya_admin' => $biayaAdmin,
                    'kode_unik' => $kodeUnik,
                    'campaign_id' => $campaign->id,
                    'doc_no' => $docNo,
                    'payment_status' => $paymentStatus,
                    'payment_link' => $paymentLink,
                    'created_at' => $createdDateTimeString,
                    'updated_at' => $createdDateTimeString,
                ]);
            }
        }
    }
}
