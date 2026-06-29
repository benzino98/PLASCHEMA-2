<?php

namespace Database\Seeders;

use App\Models\Download;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PlanBenefit;
use App\Models\SiteSetting;
use App\Models\SuccessStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSiteSettings();
        $this->seedHealthPlans();
        $this->seedFaqs();
        $this->seedNews();
        $this->seedDownloads();
        $this->seedAboutPage();
        $this->seedSuccessStories();
    }

    private function seedSiteSettings(): void
    {
        SiteSetting::set('home', 'stats', [
            ['label' => 'Enrolled Citizens', 'value' => '500K+', 'icon' => 'users'],
            ['label' => 'Accredited Providers', 'value' => '200+', 'icon' => 'building-2'],
            ['label' => 'LGAs Covered', 'value' => '17', 'icon' => 'map'],
            ['label' => 'Support Available', 'value' => '24/7', 'icon' => 'headphones'],
        ]);

        SiteSetting::set('home', 'enrollment_chart', [
            'labels' => ['2021', '2022', '2023', '2024', '2025', '2026'],
            'series' => [45000, 82000, 145000, 230000, 380000, 520000],
        ]);

        SiteSetting::set('home', 'why_plaschema', [
            ['title' => 'Affordable Coverage', 'description' => 'Quality healthcare at premiums designed for every income level across Plateau State.', 'icon' => 'wallet'],
            ['title' => 'Wide Provider Network', 'description' => 'Access accredited hospitals and clinics in all 17 Local Government Areas.', 'icon' => 'hospital'],
            ['title' => 'Transparent & Accountable', 'description' => 'Clear benefits, open processes, and government-backed oversight you can trust.', 'icon' => 'shield-check'],
            ['title' => 'Easy Digital Access', 'description' => 'Enroll, verify, and pay online — healthcare made simple for every citizen.', 'icon' => 'smartphone'],
        ]);
    }

    private function seedHealthPlans(): void
    {
        $benefitDefs = [
            'outpatient' => 'Outpatient Care',
            'inpatient' => 'Inpatient Services',
            'maternity' => 'Maternity Coverage',
            'emergency' => 'Emergency Care',
            'prescription' => 'Prescription Drugs',
            'dental' => 'Dental Care',
            'optical' => 'Optical Services',
            'screening' => 'Annual Health Screening',
        ];

        $plans = [
            ['name' => 'Formal Sector', 'slug' => 'formal-sector', 'sector' => 'formal', 'price_label' => 'Employer-backed', 'price_amount' => null, 'featured' => false,
                'description' => 'For civil servants and organized private sector employees with employer contributions.',
                'benefits' => ['outpatient' => true, 'inpatient' => true, 'maternity' => true, 'emergency' => true, 'prescription' => true, 'dental' => true, 'optical' => true, 'screening' => true]],
            ['name' => 'Informal Sector', 'slug' => 'informal-sector', 'sector' => 'informal', 'price_label' => 'From ₦12,000/year', 'price_amount' => 12000, 'featured' => true,
                'description' => 'Flexible coverage for traders, artisans, farmers, and self-employed citizens.',
                'benefits' => ['outpatient' => true, 'inpatient' => true, 'maternity' => true, 'emergency' => true, 'prescription' => true, 'dental' => false, 'optical' => false, 'screening' => true]],
            ['name' => 'Family Plan', 'slug' => 'family-plan', 'sector' => 'family', 'price_label' => 'Per household', 'price_amount' => 25000, 'featured' => false,
                'description' => 'Comprehensive protection for spouses and children under one affordable package.',
                'benefits' => ['outpatient' => true, 'inpatient' => true, 'maternity' => true, 'emergency' => true, 'prescription' => true, 'dental' => true, 'optical' => false, 'screening' => true]],
            ['name' => 'Student Plan', 'slug' => 'student-plan', 'sector' => 'student', 'price_label' => 'From ₦5,000/year', 'price_amount' => 5000, 'featured' => false,
                'description' => 'Affordable health coverage for students in tertiary and secondary institutions.',
                'benefits' => ['outpatient' => true, 'inpatient' => true, 'maternity' => false, 'emergency' => true, 'prescription' => true, 'dental' => false, 'optical' => true, 'screening' => true]],
            ['name' => 'Vulnerable Persons', 'slug' => 'vulnerable-persons', 'sector' => 'vulnerable', 'price_label' => 'BHCPF Equity Fund', 'price_amount' => null, 'featured' => false,
                'description' => 'Subsidized coverage for the poor and vulnerable through the Basic Health Care Provision Fund.',
                'benefits' => ['outpatient' => true, 'inpatient' => true, 'maternity' => true, 'emergency' => true, 'prescription' => true, 'dental' => false, 'optical' => false, 'screening' => true]],
        ];

        foreach ($plans as $i => $planData) {
            $plan = HealthPlan::create([
                'name' => $planData['name'],
                'slug' => $planData['slug'],
                'sector' => $planData['sector'],
                'description' => $planData['description'],
                'price_label' => $planData['price_label'],
                'price_amount' => $planData['price_amount'],
                'is_featured' => $planData['featured'],
                'sort_order' => $i + 1,
            ]);

            foreach ($benefitDefs as $key => $label) {
                PlanBenefit::create([
                    'health_plan_id' => $plan->id,
                    'benefit_key' => $key,
                    'benefit_label' => $label,
                    'is_included' => $planData['benefits'][$key] ?? false,
                    'sort_order' => array_search($key, array_keys($benefitDefs)) + 1,
                ]);
            }
        }
    }

    private function seedFaqs(): void
    {
        $categories = [
            'enrollment' => [
                'name' => 'Enrollment',
                'faqs' => [
                    ['Who is eligible for PLASCHEMA?', 'All residents of Plateau State are eligible, including formal and informal sector workers, students, families, and vulnerable persons under the BHCPF equity program.'],
                    ['How do I enroll online?', 'Visit the online enrollment portal, create an account, select your plan, provide required details, and pay your premium. You will receive a confirmation and membership ID.'],
                    ['What documents do I need?', 'A valid ID (NIN, voter card, or passport), passport photograph, and proof of residence. Employers may require additional documentation for formal sector enrollment.'],
                ],
            ],
            'coverage' => [
                'name' => 'Coverage & Benefits',
                'faqs' => [
                    ['What services are covered?', 'Coverage includes outpatient care, inpatient treatment, maternity services, emergency care, prescription drugs, and more depending on your plan.'],
                    ['Can I add family members?', 'Yes. The Family Plan covers spouse and dependent children. Additional members can be added during enrollment or renewal.'],
                    ['Is pre-existing condition covered?', 'PLASCHEMA covers essential health services. Specific pre-existing condition policies are outlined in your plan guidelines.'],
                ],
            ],
            'providers' => [
                'name' => 'Providers & Claims',
                'faqs' => [
                    ['How do I find an accredited hospital?', 'Use the Find Healthcare Provider page to search by LGA, specialty, or hospital name. You can also view providers on an interactive map.'],
                    ['Can I visit any hospital?', 'You should visit PLASCHEMA-accredited providers to receive covered services. Non-accredited visits may require out-of-pocket payment.'],
                    ['How do I verify my enrollment?', 'Use the Membership Verification portal with your membership ID or registered phone number to confirm your active status.'],
                ],
            ],
            'payments' => [
                'name' => 'Payments & Renewal',
                'faqs' => [
                    ['How much does coverage cost?', 'Premiums vary by plan. Informal sector starts from ₦12,000/year, student plans from ₦5,000/year, and vulnerable persons are covered through BHCPF equity funding.'],
                    ['How do I renew my membership?', 'Visit the premium payment portal before your expiry date. You will receive renewal reminders via SMS and email.'],
                    ['What payment methods are accepted?', 'Online payments via card and bank transfer are accepted on the payment portal. Cash payments are available at PLASCHEMA offices.'],
                ],
            ],
        ];

        foreach ($categories as $slug => $data) {
            $cat = FaqCategory::create([
                'name' => $data['name'],
                'slug' => $slug,
                'sort_order' => array_search($slug, array_keys($categories)) + 1,
            ]);

            foreach ($data['faqs'] as $i => [$question, $answer]) {
                Faq::create([
                    'faq_category_id' => $cat->id,
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }

    private function seedNews(): void
    {
        $articles = [
            ['title' => 'PLASCHEMA Launches 2026 Enrollment Drive', 'category' => 'activity', 'days_ago' => 3,
                'excerpt' => 'The agency kicks off a statewide campaign to enroll 100,000 new members before the end of the year.',
                'body' => '<p>The Plateau State Contributory Healthcare Management Agency has launched its 2026 enrollment drive, targeting 100,000 new enrollees across all 17 Local Government Areas.</p><p>Director General announced that mobile enrollment units will visit markets, schools, and community centres to make registration accessible to informal sector workers and rural communities.</p><p>Citizens can also enroll online through the digital portal at any time.</p>'],
            ['title' => 'Free Maternal Health Screening in Jos North', 'category' => 'campaign', 'days_ago' => 8,
                'excerpt' => 'A week-long health campaign offering free antenatal screenings for enrolled and new members.',
                'body' => '<p>PLASCHEMA, in partnership with Jos University Teaching Hospital, is offering free maternal health screenings for pregnant women in Jos North LGA.</p><p>The campaign runs for one week and includes blood pressure checks, ultrasound scans, and nutritional counselling.</p>'],
            ['title' => '200 Healthcare Facilities Now Accredited', 'category' => 'press', 'days_ago' => 14,
                'excerpt' => 'PLASCHEMA reaches a milestone with 200 accredited providers across Plateau State.',
                'body' => '<p>PLASCHEMA has accredited its 200th healthcare facility, expanding access to quality care in underserved communities.</p><p>The newly accredited facilities include primary health centres in Kanam, Mangu, and Barkin Ladi LGAs.</p>'],
            ['title' => 'Understanding Your Health Plan Benefits', 'category' => 'article', 'days_ago' => 21,
                'excerpt' => 'A guide to help enrollees understand what their PLASCHEMA plan covers and how to access services.',
                'body' => '<p>Many enrollees are unaware of the full range of benefits available under their health plan. This guide explains outpatient care, emergency services, maternity coverage, and how to use your membership card at accredited facilities.</p>'],
            ['title' => 'BHCPF Equity Fund Reaches 50,000 Vulnerable Citizens', 'category' => 'activity', 'days_ago' => 30,
                'excerpt' => 'The Basic Health Care Provision Fund equity program continues to expand coverage for the poor and vulnerable.',
                'body' => '<p>Through the BHCPF equity program, PLASCHEMA has enrolled 50,000 vulnerable citizens who previously had no access to health insurance.</p><p>The program prioritises pregnant women, children under five, the elderly, and persons with disabilities.</p>'],
            ['title' => 'World Health Day: PLASCHEMA Community Outreach', 'category' => 'campaign', 'days_ago' => 45,
                'excerpt' => 'Community health talks and free blood pressure checks mark World Health Day celebrations.',
                'body' => '<p>PLASCHEMA marked World Health Day with community outreach events in Bukuru, Pankshin, and Shendam, providing free health screenings and enrollment assistance.</p>'],
        ];

        foreach ($articles as $article) {
            NewsArticle::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'excerpt' => $article['excerpt'],
                'body' => $article['body'],
                'category' => $article['category'],
                'published_at' => now()->subDays($article['days_ago']),
                'is_published' => true,
            ]);
        }
    }

    private function seedDownloads(): void
    {
        Storage::disk('public')->makeDirectory('downloads');

        $files = [
            ['title' => 'Enrollment Application Form', 'category' => 'form', 'filename' => 'enrollment-form.pdf'],
            ['title' => 'PLASCHEMA Operational Guidelines', 'category' => 'guideline', 'filename' => 'operational-guidelines.pdf'],
            ['title' => 'Health Insurance Policy Framework', 'category' => 'policy', 'filename' => 'policy-framework.pdf'],
            ['title' => 'Annual Report 2025', 'category' => 'report', 'filename' => 'annual-report-2025.pdf'],
            ['title' => 'Provider Accreditation Form', 'category' => 'form', 'filename' => 'provider-accreditation-form.pdf'],
            ['title' => 'Premium Tariff Circular 2026', 'category' => 'circular', 'filename' => 'tariff-circular-2026.pdf'],
            ['title' => 'Benefits Package Guidelines', 'category' => 'guideline', 'filename' => 'benefits-guidelines.pdf'],
            ['title' => 'Membership Renewal Form', 'category' => 'form', 'filename' => 'renewal-form.pdf'],
        ];

        foreach ($files as $file) {
            $path = 'downloads/'.$file['filename'];
            $content = "%PDF-1.4\n% PLASCHEMA Placeholder - {$file['title']}\n";
            Storage::disk('public')->put($path, $content);

            Download::create([
                'title' => $file['title'],
                'slug' => Str::slug($file['title']),
                'category' => $file['category'],
                'description' => "Official PLASCHEMA document: {$file['title']}.",
                'file_path' => $path,
                'file_size' => strlen($content),
                'mime_type' => 'application/pdf',
                'published_at' => now(),
                'is_published' => true,
            ]);
        }
    }

    private function seedAboutPage(): void
    {
        $page = Page::create([
            'slug' => 'about',
            'title' => 'About PLASCHEMA',
            'meta_description' => 'Learn about the Plateau State Contributory Healthcare Management Agency — our mission, vision, leadership, and history.',
        ]);

        $sections = [
            ['key' => 'mission', 'title' => 'Our Mission', 'content' => 'To provide affordable, accessible, and quality healthcare to all residents of Plateau State through a sustainable contributory health insurance scheme that leaves no citizen behind.'],
            ['key' => 'vision', 'title' => 'Our Vision', 'content' => 'A Plateau State where every citizen enjoys universal health coverage, financial protection from catastrophic health expenses, and equitable access to quality healthcare services.'],
            ['key' => 'objectives', 'title' => 'Our Objectives', 'content' => json_encode([
                'Increase health insurance coverage across all sectors of Plateau State society',
                'Ensure quality healthcare services through an accredited provider network',
                'Protect families from financial hardship caused by medical expenses',
                'Promote preventive healthcare and health education campaigns',
                'Implement the Basic Health Care Provision Fund (BHCPF) equity program for vulnerable groups',
                'Leverage technology for efficient enrollment, verification, and service delivery',
            ])],
            ['key' => 'dg_profile', 'title' => 'Director General', 'content' => json_encode([
                'name' => 'Dr. [Director General Name]',
                'title' => 'Director General / CEO',
                'bio' => 'The Director General leads PLASCHEMA with a commitment to universal health coverage for Plateau State. With extensive experience in public health administration and health financing, the DG oversees the agency\'s strategic direction, stakeholder engagement, and operational excellence.',
                'image' => null,
            ])],
            ['key' => 'history', 'title' => 'Our History', 'content' => json_encode([
                ['year' => '2018', 'event' => 'Plateau State establishes the Contributory Healthcare Management Agency following the National Health Act.'],
                ['year' => '2019', 'event' => 'PLASCHEMA launches pilot enrollment for formal sector workers in Jos metropolis.'],
                ['year' => '2021', 'event' => 'Informal sector and family plans introduced, expanding coverage to traders and artisans.'],
                ['year' => '2023', 'event' => 'BHCPF equity program launched, enrolling vulnerable citizens across all 17 LGAs.'],
                ['year' => '2025', 'event' => 'Digital enrollment and verification portals go live, surpassing 500,000 enrolled citizens.'],
                ['year' => '2026', 'event' => 'PLASCHEMA continues expansion with 200+ accredited providers and statewide outreach campaigns.'],
            ])],
            ['key' => 'gallery', 'title' => 'Gallery', 'content' => json_encode([
                ['src' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80', 'caption' => 'Community health outreach'],
                ['src' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80', 'caption' => 'Healthcare professionals at work'],
                ['src' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=800&q=80', 'caption' => 'Modern healthcare facility'],
                ['src' => 'https://images.unsplash.com/photo-1631217868264-e4b985a1e4f0?w=800&q=80', 'caption' => 'Enrollment drive event'],
                ['src' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=800&q=80', 'caption' => 'Maternal health campaign'],
                ['src' => 'https://images.unsplash.com/photo-1581594549595-35f6a7a62f36?w=800&q=80', 'caption' => 'PLASCHEMA team meeting'],
            ])],
        ];

        foreach ($sections as $i => $section) {
            PageSection::create([
                'page_id' => $page->id,
                'key' => $section['key'],
                'title' => $section['title'],
                'content' => $section['content'],
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function seedSuccessStories(): void
    {
        $stories = [
            ['title' => 'A Life-Saving Surgery', 'author_name' => 'Grace M.', 'author_location' => 'Jos North', 'excerpt' => 'PLASCHEMA covered my emergency surgery when I had no savings. I received treatment at JUTH without paying out of pocket.'],
            ['title' => 'Safe Delivery for My Twins', 'author_name' => 'Amina B.', 'author_location' => 'Barkin Ladi', 'excerpt' => 'My maternity coverage paid for my entire delivery including complications. I am grateful for the peace of mind.'],
            ['title' => 'Healthcare for My Whole Family', 'author_name' => 'James P.', 'author_location' => 'Pankshin', 'excerpt' => 'The family plan covers my wife and three children. We visit our local PHC without worrying about costs.'],
        ];

        foreach ($stories as $i => $story) {
            SuccessStory::create([
                'title' => $story['title'],
                'excerpt' => $story['excerpt'],
                'author_name' => $story['author_name'],
                'author_location' => $story['author_location'],
                'sort_order' => $i + 1,
            ]);
        }
    }
}
