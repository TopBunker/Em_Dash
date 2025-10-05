<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ResumeSeeder extends Seeder
{
    /**
     * Run the Resume seeds.
     */
    public function run(): void
    {
        // Real
        $this->add();

        // Faker (for testing)
        Resume::factory()
                ->hasPersonalAddress()
                ->hasImage()
                ->hasSkills()
                ->hasReferences(3)
                ->hasPortfolios()
                ->has(Education::factory()->hasEduDetail()->hasEduCertificates()->hasInstitutionAddress(), 'educations')
                ->has(Experience::factory()->count(3)->hasEmployerAddress()->hasTasks(3)->hasAccomplishments(3))
                ->create();
    }

    /**
     * 
     * @return string 
     * @throws InvalidArgumentException 
     * @throws InvalidCastException 
     * @throws ModelNotFoundException 
     */
    public function add() {

        try{
            DB::transaction(function () {
                // user
                $user = User::create([
                    'last_name' => 'Delahaye',
                    'first_name' => 'Jordane',
                    'email' => 'jordane.delahaye@icloud.com',
                    'password' => Hash::make('r!ght@th!sm0m3nt')
                ]);

                // resume
                $res = new Resume();
                $res->user_id = $user->id;
                $res->tel = '+1 876 471-2446';
                $res->title = 'Writer | Software Developer (Full-Stack Web Focus)';
                $res->summary = 'Writer with over a decade of experience in journalism, content production, and copywriting, as well as experience in web development and technical training in software development and documentation. Multifaceted perspective informed by a diverse, multicultural professional background.';
                $res->status = 'final';
                $res->hasPort = true;
                $res->hasImage = true;
                $res->file_location = 'files/delahaye-jordane-cv.pdf';
                $res->save();
                $res->refresh();

                // address
                $res->personalAddress()->create([
                    'city' => 'Kingston',
                    'state' => 'St. Andrew',
                    'country_code' => 'JM',
                    'zip' => 'JMAAW12'
                ]);

                $res->image()->create([
                    'file_location' => 'user/v2.5.JPG'
                ]);

                // education
                $edu = $res->educations()->create([
                    'institution' => 'University of the West Indies',
                    'start_date' => Carbon::createFromFormat('Y-m-d','2014-09-01'),
                    'end_date' => Carbon::createFromFormat('Y-m-d', '2018-06-01'),
                    'degree' => 'Bachelor\'s Degree',
                    'level' => 'tertiary'
                ]);

                $edu->eduDetail()->create([
                    'detail' => 'Computer Science and Japanese Studies'
                ]);

                // experience 1
                $exp1 = $res->experiences()->create([
                    'start_date' => Carbon::createFromFormat('Y-m-d', '2023-01-01'),
                    'position' => 'Writer/Consultant',
                    'employer' => 'Self',
                    'business_type' => 'Consultancy'
                ]);

                $exp1->tasks()->createMany([
                    ['heading' => 'Content Strategy and Production with SEO',
                    'task' => 'Produce content aligned with marketing goals.'],
                    ['heading' => 'Content Strategy and Production with SEO',
                    'task' => 'Develop and implement search engine optimization (SEO) strategy, including keyword research.'],
                    ['heading' => 'Copywriting',
                    'task' => 'Produce copy for email campaigns.'],
                    ['heading' => 'Copywriting',
                    'task' => 'Create, schedule and manage campaigns.'],
                    ['heading' => 'E-Learning Course Design and Development',
                    'task' => 'Elicit objectives according to stakeholder requirements.'],
                    ['heading' => 'E-Learning Course Design and Development',
                    'task' => 'Research and implement educational content according to best practices in e-learning course development.'],
                    ['heading' => 'E-Learning Course Design and Development',
                    'task' => 'Learn Articulate software to produce a leadership course for a learning management system.'],
                    ['heading' => 'Freelance Reporting',
                    'task' => 'Conduct interviews with key stakeholders, including coporate executives, founders and various personalities.'],
                    ['heading' => 'Freelance Reporting',
                    'task' => 'Research and fact-check information.'],
                ]);

                $exp1->accomplishments()->createMany([
                    ['heading' => 'Content Strategy and Production with SEO',
                    'accomplishment' => 'Grew subscriptions by more than 67% in 3 months.'],
                    ['heading' => 'Copywriting',
                    'accomplishment' => 'Maintained high-performing click-through rates of 4% or higher (based on industry benchmarks).'],
                    ['heading' => 'E-Learning Course Design and Development',
                    'accomplishment' => 'Completed e-learning course outline, design and production based on stakeholder needs.'],
                    ['heading' => 'Freelance Reporting',
                    'accomplishment' => 'Reported on various events for a print media company with a readership of over 3 million.']
                ]);

                // experience 2
                $exp2 = $res->experiences()->create([
                    'start_date' => Carbon::createFromFormat('Y-m-d', '2023-01-01'),
                    'position' => 'Developer/IT Consultant',
                    'employer' => 'Self',
                    'business_type' => 'Consultancy'
                ]);

                $exp2->tasks()->createMany([
                    ['heading' => 'Web Development',
                    'task' => 'Elicit, access and produce requirements according to stakeholder objectives.'],
                    ['heading' => 'Web Development',
                    'task' => 'Design and develop custom functionality, including a form for users to submit documents via email to a designated recipient.'],
                    ['heading' => 'Web Development',
                    'task' => 'SEO, including mobile optimization and producing meta descriptions.'],
                    ['heading' => 'IT Consulting',
                    'task' => 'Facilitated remote backup of sensitive data.'],
                    ['heading' => 'IT Consulting',
                    'task' => 'Securely wiped and removed server discs.'],
                    ['heading' => 'IT Consulting',
                    'task' => 'Liased with IT professional to transfer system to new company.'],
                ]);

                $exp2->accomplishments()->createMany([
                    ['heading' => 'Web Development',
                    'accomplishment' => 'Designed and developed website achieving scores of 100% on best practices, 98% on accessibility, 95% on performance, and 92% on SEO according to a Google Lighthouse audit.'],
                    ['heading' => 'IT Consulting',
                    'accomplishment' => 'Joined an international shipping crew on a chemical tanker at sea for three days, quickly adapted to the new environment, completed objectives, and produced a detailed report for international stakeholders. ']
                ]);

                // experience 3
                $exp3 = $res->experiences()->create([
                    'start_date' => Carbon::createFromFormat('Y-m-d','2018-07-01'),
                    'end_date' => Carbon::createFromFormat('Y-m-d', '2022-07-01'),
                    'position' => 'Assitance Language Instructor',
                    'employer' => 'Iwamizawa Board of Education/Iwamizawa City, Hokkaido, Japan',
                    'business_type' => 'Education'
                ]);

                $exp3->tasks()->createMany([
                    ['heading' => 'Lesson Planning and Delivery',
                    'task' => 'Research and produce lesson plans according to the curriculum and student needs.'],
                    ['heading' => 'Lesson Planning and Delivery',
                    'task' => 'Deliver lessons, guide student engagement and test learning.'],
                    ['heading' => 'Learning Development',
                    'task' => 'Research, develop and present processes and activities for simulating immersion in the classroom.']
                ]);

                $exp3->accomplishments()->createMany([
                    ['heading' => 'Lesson Planning and Delivery',
                    'accomplishment' => 'Developed a close bond with Japanese students, which helped to drive engagement and interest in foreign cultures and languages.'],
                    ['heading' => 'Learning Development',
                    'accomplishment' => 'Developed a website with custom-built games designed to continuously reinforce fundamental elements of the English Language.'],
                    ['heading' => 'Learning Development',
                    'accomplishment' => 'Recorded improvement in engagement, response speed, and test performance in target areas through the website.'],
                    ['accomplishment' => 'An invaluable part of this experience was the cross-cultural awareness developed in assessing the needs of Japanese coworkers and Japanese students.']
                ]);

                // experience 4
                $exp4 = $res->experiences()->create([
                    'start_date' => Carbon::createFromFormat('Y-m-d', '2012-06-01'),
                    'end_date' => Carbon::createFromFormat('Y-m-d', '2014-06-01'),
                    'position' => 'Freelance Writer/Journalist',
                    'employer' => 'Various',
                    'business_type' => 'Media/Publishing'
                ]);

                $exp4->tasks()->createMany([
                    ['heading' => 'News Reporting',
                    'task' => 'Research and produce news reports for the business and entertainment desks of a national news agency.'],
                    ['heading' => 'News Reporting',
                    'task' => 'Conduct interviews.'],
                    ['heading' => 'Freelance Writing',
                    'task' => 'Research and produce reviews of events, music albums, etc.'],
                    ['heading' => 'Freelance Writing',
                    'task' => 'Produce speeches, copy and other content according to client needs.']
                ]);

                $exp4->accomplishments()->createMany([
                    ['heading' => 'News Reporting',
                    'accomplishment' => 'Prolific in producing news reports on various topics, including multiple lead stories.'],
                    ['heading' => 'Freelance Writing',
                    'accomplishment' => 'Gained a wide breadth of experience in content production and marketing communications.'],
                ]);

                // skills
                $res->skills()->createMany([
                    ['category' => 'Technical Skills',
                    'description' => 'Training in computer science and software development methodology; ability to learn new technology quickly.'],
                    ['category' => 'Technical Skills',
                    'sub_category' => 'Programming Languages',
                    'description' => 'PHP, Java, HTML/CSS, JavaScript, SQL'],
                    ['category' => 'Technical Skills',
                    'sub_category' => 'Frameworks/Libraries',
                    'description' => 'Laravel, Livewire, Alpine.js, Angular, Pixijs'],
                    ['category' => 'Technical Skills',
                    'sub_category' => 'Platforms',
                    'description' => 'Articulate 360, Wix, WordPress'],
                    ['category' => 'Technical Skills',
                    'sub_category' => 'Other',
                    'description' => 'Final Cut Pro, Logic Pro, Affinity Designer/Publisher/Photo'],
                    ['category' => 'Interpersonal Skills',
                    'description' => 'Oral and written communication skills honed through years of professional experience working alongside teammates from various countries and cultures.'],
                    ['category' => 'Organizational Skills',
                    'description' => 'Continuous development in critical thinking, documentation, and self-management.'],
                    ['category' => 'Language',
                    'description' => 'English',
                    'level' => 'Native'],
                    ['category' => 'Language',
                    'description' => 'Japanese',
                    'level' => 'N3'],
                    ['category' => 'Learning & Development',
                    'description' => 'Recently completed International Institute of Business Analysis and Project Management Institute-approved courses in business analysis and project management, to support continued learning and development.'],
                    ['category' => 'Further Intersets',
                    'description' => 'My interests include problem-solving and exploring language beyond the postmodern, through poetry and creative fiction. I challenge myself to read and write widely.'],
                ]);

                // portfolio
                $res->portfolios()->create([
                    'title' => 'Writer',
                    'description' => 'My writing career began in high school, where I conducted interviews, reported on events and contributed various articles to a weekly, youth-oriented publication. 
                        I have since gained further expert guidance under the tutelage of seasoned editors. As a university student, I worked part-time with a medical professional to produce medical reports for insurance claims. 
                        This professional experience as a technical writer complemented the training I was already receiving as a computer science major. Since then, I have specialized in content production for marketing, public relations, and education.',
                    'file_location' => 'files/delahaye-jordane-portfolio.pdf',
                    'script' => 'writer',
                ]);

                $web = $res->portfolios()->create([
                    'title' => 'Software Developer (Full-Stack Web Focus)',
                    'description' => 'My programming experience began in high school, where I developed a personnel management system in C++ for a class project. I then completed my degree in Computer Science. For my capstone project, I led a group of four in developing a rudimentary chess AI in Python and Java. 
                    After graduating, I worked in Hokkaido as an English teacher, and took the initiative to design and develop a website for Japanese students to continuously reinforce fundamental elements of the English language. Although the website is no longer maintained, its use in the classroom resulted in improved engagement, response speed, and retention in target areas. 
                    Whether it\'s crafting effective content that bridges technical and non-technical perspectives, or designing and implementing scalable, fault-tolerant software, my approach is holistic. I  consider how people, processes, and technology interact in the overall system to achieve effective and efficient results. As a full-stack web developer, this means I examine how frontend, backend, and database systems are integrated to ensure reliability. 
'
                ]);

                $pro1 = $web->projects()->create([
                    'title' => 'barabaraenglish.jp (defunct)',
                    'details' => 'Website for Japanese students to practice and reinforce their English studies.'
                ]);

                $pro1->projectMedia()->create([
                    'location' => 'media/infoG.PNG',
                    'type' => 'image/png'
                ]);

                $web->projects()->create([
                    'title' => 'seaviecaribbean.com',
                    'link' => 'https://www.seaviecaribbean.com'
                ]);

                $pro3 = $web->projects()->create([
                    'title' => 'Dash (this website)',
                    'details' => 'Dash is an ongoing project to develop a streamlined, easy-to-use platform for creators to showcase their work via customizable single-page apps.'
                ]);

                $pro3->projectMedia()->create([
                    'location' => 'https://github.com/TopBunker/Em_Dash/tree/main',
                    'type' => 'link'
                ]);


            }); 
        }catch (Throwable $e){
            report($e);
            return ['error' => $e->getMessage()];
        }        
    }
}
