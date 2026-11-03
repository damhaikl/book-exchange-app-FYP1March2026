<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookRequest;
use App\Models\BookSchedule;
use App\Models\Report;
use App\Models\Review;
use App\Models\SavedBook;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Add repeatable sample records for local development and demonstrations.
     * These credentials and records are for local testing only.
     */
    public function run(): void
    {
        $password = Hash::make('DemoPass123!');

        $users = collect([
            [
                'studentid' => '52226010001',
                'name' => 'Demo Administrator',
                'email' => 'demo.admin@example.com',
                'role' => 'admin',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Software Engineering with Honours',
            ],
            [
                'studentid' => '52226010002',
                'name' => 'Demo Super Admin',
                'email' => 'demo.superadmin@example.com',
                'role' => 'super_admin',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Cybersecurity Technology with Honours',
            ],
            [
                'studentid' => '52026010001',
                'name' => 'Aina Rahman',
                'email' => 'aina.demo@example.com',
                'role' => 'student',
                'education_level' => 'Foundation',
                'programme' => 'Foundation in Computer Technology',
            ],
            [
                'studentid' => '52126010001',
                'name' => 'Daniel Lee',
                'email' => 'daniel.demo@example.com',
                'role' => 'student',
                'education_level' => 'Diploma',
                'programme' => 'Diploma in Information Technology',
            ],
            [
                'studentid' => '52226010003',
                'name' => 'Farah Ismail',
                'email' => 'farah.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Artificial Intelligence Technology with Honours',
            ],
            [
                'studentid' => '52226010004',
                'name' => 'Jason Tan',
                'email' => 'jason.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Computer Engineering Technology (Networking Systems) with Honours',
            ],
            [
                'studentid' => '52126010002',
                'name' => 'Mei Wong',
                'email' => 'mei.demo@example.com',
                'role' => 'student',
                'education_level' => 'Diploma',
                'programme' => 'Diploma in Multimedia',
            ],
            [
                'studentid' => '52026010002',
                'name' => 'Demo Foundation Science Student',
                'email' => 'foundation.science.demo@example.com',
                'role' => 'student',
                'education_level' => 'Foundation',
                'programme' => 'Foundation in Science and Technology for Korean University',
            ],
            [
                'studentid' => '52126010003',
                'name' => 'Demo Networking Diploma Student',
                'email' => 'networking.diploma.demo@example.com',
                'role' => 'student',
                'education_level' => 'Diploma',
                'programme' => 'Diploma in Networking Technology',
            ],
            [
                'studentid' => '52126010004',
                'name' => 'Demo Animation Diploma Student',
                'email' => 'animation.diploma.demo@example.com',
                'role' => 'student',
                'education_level' => 'Diploma',
                'programme' => 'Diploma in Animation',
            ],
            [
                'studentid' => '52226010005',
                'name' => 'Demo Game Development Student',
                'email' => 'game.development.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Game Development Technology with Honours',
            ],
            [
                'studentid' => '52226010006',
                'name' => 'Demo Internet of Things Student',
                'email' => 'iot.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor in Information Technology (Honours) (Internet of Things)',
            ],
            [
                'studentid' => '52226010007',
                'name' => 'Demo Interactive Multimedia Student',
                'email' => 'interactive.multimedia.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Multimedia Technology (Hons.) in Interactive Multimedia Design',
            ],
            [
                'studentid' => '52226010008',
                'name' => 'Demo Computer Animation Student',
                'email' => 'computer.animation.demo@example.com',
                'role' => 'student',
                'education_level' => 'Bachelor',
                'programme' => 'Bachelor of Multimedia Technology (Hons.) in Computer Animation',
            ],
        ])->mapWithKeys(function (array $attributes) use ($password) {
            $email = $attributes['email'];
            $user = User::updateOrCreate(
                ['email' => $email],
                [...$attributes, 'password' => $password]
            );
            $user->email_verified_at = now();
            $user->save();

            return [$email => $user];
        });

        $bookRows = [
            ['key' => 'algorithms', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Introduction to Algorithms', 'description' => 'A well-kept reference for algorithm design, sorting, graphs, and problem solving.', 'condition' => 'Like New', 'subject_id' => 'CSC301', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 25.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 3, 'meeting_time' => '14:00:00', 'meeting_end_time' => '16:00:00'],
            ['key' => 'calculus', 'owner' => 'daniel.demo@example.com', 'title' => 'DEMO — Calculus: Early Transcendentals', 'description' => 'Calculus textbook with clear examples and some notes in the margins.', 'condition' => 'Used', 'subject_id' => 'MAT202', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 15.00, 'meeting_location' => 'Block A student lounge', 'meeting_day' => 4, 'meeting_time' => '11:30:00', 'meeting_end_time' => '13:00:00'],
            ['key' => 'database', 'owner' => 'farah.demo@example.com', 'title' => 'DEMO — Database System Concepts', 'description' => 'Useful for SQL, relational database design, normalization, and transactions.', 'condition' => 'New', 'subject_id' => 'CSC315', 'subject_category' => 'Elective Subject', 'status' => 'reserved', 'price' => 30.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 5, 'meeting_time' => '15:00:00', 'meeting_end_time' => '17:00:00'],
            ['key' => 'software', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Software Engineering', 'description' => 'Covers requirements, design, testing, and software project management.', 'condition' => 'Like New', 'subject_id' => 'SWE301', 'subject_category' => 'Elective Subject', 'status' => 'sold', 'price' => 20.00, 'meeting_location' => 'Block B cafeteria', 'meeting_day' => 2, 'meeting_time' => '13:00:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'networks', 'owner' => 'jason.demo@example.com', 'title' => 'DEMO — Computer Networking: A Top-Down Approach', 'description' => 'Networking fundamentals with chapters on HTTP, routing, and transport protocols for Bachelor of Computer Engineering Technology (Networking Systems) students.', 'condition' => 'Used', 'subject_id' => 'CSC322', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 18.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 6, 'meeting_time' => '10:00:00', 'meeting_end_time' => '11:30:00'],
            ['key' => 'discrete', 'owner' => 'mei.demo@example.com', 'title' => 'DEMO — Discrete Mathematics and Its Applications', 'description' => 'Topics include logic, proofs, combinatorics, graphs, and discrete probability.', 'condition' => 'Used', 'subject_id' => 'MAT210', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 0.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 7, 'meeting_time' => '12:30:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'operating-systems', 'owner' => 'farah.demo@example.com', 'title' => 'DEMO — Operating System Concepts', 'description' => 'An introductory text on processes, memory, file systems, and concurrency.', 'condition' => 'Like New', 'subject_id' => 'CSC330', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 22.00, 'meeting_location' => 'Block C study area', 'meeting_day' => 8, 'meeting_time' => '16:00:00', 'meeting_end_time' => '18:00:00'],
            ['key' => 'web', 'owner' => 'daniel.demo@example.com', 'title' => 'DEMO — Web Application Development', 'description' => 'Practical introduction to HTTP, web forms, databases, and application security.', 'condition' => 'New', 'subject_id' => 'WEB201', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 12.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 9, 'meeting_time' => '14:30:00', 'meeting_end_time' => '16:00:00'],
            ['key' => 'academic-english', 'owner' => 'jason.demo@example.com', 'title' => 'DEMO — Academic English for University Studies', 'description' => 'A language reference for academic reading, writing, presentations, and university coursework.', 'condition' => 'Like New', 'subject_id' => 'ENGL201', 'subject_category' => 'University Compulsory Subject', 'status' => 'available', 'price' => 9.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 10, 'meeting_time' => '10:00:00', 'meeting_end_time' => '11:00:00'],
            ['key' => 'fyp-guide', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Final Year Project Handbook', 'description' => 'A practical guide to planning, researching, documenting, and presenting a final year project.', 'condition' => 'Like New', 'subject_id' => 'FYP401', 'subject_category' => 'Final Year Project', 'status' => 'available', 'price' => 10.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 10, 'meeting_time' => '13:00:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'mpu-ethics', 'owner' => 'mei.demo@example.com', 'title' => 'DEMO — Penghayatan Etika dan Peradaban', 'description' => 'An introductory reference on ethics, society, culture, and nation building for MPU studies.', 'condition' => 'Used', 'subject_id' => 'MPU101', 'subject_category' => 'MPU Subject', 'status' => 'available', 'price' => 8.00, 'meeting_location' => 'Block A student lounge', 'meeting_day' => 11, 'meeting_time' => '12:00:00', 'meeting_end_time' => '13:00:00'],
            ['key' => 'foundation-science', 'owner' => 'foundation.science.demo@example.com', 'title' => 'DEMO — Foundation Science and Mathematics', 'description' => 'Foundation-level science and mathematics practice for students in Foundation in Computer Technology and Foundation in Science and Technology for Korean University.', 'condition' => 'Like New', 'subject_id' => 'FST101', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 11.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 12, 'meeting_time' => '10:00:00', 'meeting_end_time' => '11:00:00'],
            ['key' => 'networking-diploma', 'owner' => 'networking.diploma.demo@example.com', 'title' => 'DEMO — Diploma Networking Fundamentals', 'description' => 'Covers IP addressing, routing, switching, and network troubleshooting for Diploma in Networking Technology students.', 'condition' => 'Used', 'subject_id' => 'DNT201', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 14.00, 'meeting_location' => 'Block C study area', 'meeting_day' => 12, 'meeting_time' => '11:00:00', 'meeting_end_time' => '12:00:00'],
            ['key' => 'animation-diploma', 'owner' => 'animation.diploma.demo@example.com', 'title' => 'DEMO — Animation Principles and Storyboarding', 'description' => 'An introductory reference on motion, timing, character poses, and storyboarding for Diploma in Animation students.', 'condition' => 'Like New', 'subject_id' => 'DAN201', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 17.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 13, 'meeting_time' => '13:00:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'game-development', 'owner' => 'game.development.demo@example.com', 'title' => 'DEMO — Game Programming Patterns', 'description' => 'Explains game loops, state, entities, and gameplay architecture for Bachelor of Game Development Technology students.', 'condition' => 'Used', 'subject_id' => 'GDT301', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 19.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 13, 'meeting_time' => '14:00:00', 'meeting_end_time' => '15:00:00'],
            ['key' => 'iot-systems', 'owner' => 'iot.demo@example.com', 'title' => 'DEMO — Internet of Things Systems and Sensors', 'description' => 'Introduces connected devices, sensors, embedded systems, and IoT communication for the Bachelor in Information Technology (Internet of Things) programme.', 'condition' => 'New', 'subject_id' => 'IOT301', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 21.00, 'meeting_location' => 'Block B cafeteria', 'meeting_day' => 14, 'meeting_time' => '10:00:00', 'meeting_end_time' => '11:00:00'],
            ['key' => 'interactive-multimedia', 'owner' => 'interactive.multimedia.demo@example.com', 'title' => 'DEMO — Interactive Multimedia Design', 'description' => 'Covers interaction design, user experience, and multimedia authoring for Bachelor of Multimedia Technology Interactive Multimedia Design students.', 'condition' => 'Like New', 'subject_id' => 'IMD301', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 16.00, 'meeting_location' => 'Block A student lounge', 'meeting_day' => 14, 'meeting_time' => '12:00:00', 'meeting_end_time' => '13:00:00'],
            ['key' => 'computer-animation', 'owner' => 'computer.animation.demo@example.com', 'title' => 'DEMO — 3D Animation and Character Design', 'description' => 'Introduces 3D modelling, rigging, character movement, and rendering for Bachelor of Multimedia Technology Computer Animation students.', 'condition' => 'Used', 'subject_id' => 'CAN301', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 18.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 15, 'meeting_time' => '15:00:00', 'meeting_end_time' => '16:00:00'],
            ['key' => 'ai-machine-learning', 'owner' => 'farah.demo@example.com', 'title' => 'DEMO — Artificial Intelligence and Machine Learning', 'description' => 'An introduction to search, machine learning, neural networks, and responsible AI for Bachelor of Artificial Intelligence Technology with Honours students.', 'condition' => 'Like New', 'subject_id' => 'AIT301', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 24.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 12, 'meeting_time' => '15:00:00', 'meeting_end_time' => '16:00:00'],
            ['key' => 'cybersecurity', 'owner' => 'demo.superadmin@example.com', 'title' => 'DEMO — Cybersecurity Fundamentals', 'description' => 'Covers network defense, access control, cryptography, and risk basics for Bachelor of Cybersecurity Technology with Honours students.', 'condition' => 'Used', 'subject_id' => 'CYS301', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 20.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 13, 'meeting_time' => '11:00:00', 'meeting_end_time' => '12:00:00'],
            ['key' => 'diploma-it', 'owner' => 'daniel.demo@example.com', 'title' => 'DEMO — IT Systems and Web Applications', 'description' => 'A practical introduction to databases, web applications, and IT systems for Diploma in Information Technology students.', 'condition' => 'Like New', 'subject_id' => 'DIT201', 'subject_category' => 'Common Core Subject', 'status' => 'available', 'price' => 13.00, 'meeting_location' => 'Block A student lounge', 'meeting_day' => 13, 'meeting_time' => '12:00:00', 'meeting_end_time' => '13:00:00'],
            ['key' => 'diploma-multimedia', 'owner' => 'mei.demo@example.com', 'title' => 'DEMO — Multimedia Production and Design', 'description' => 'A practical guide to digital imaging, audio, video, and multimedia authoring for Diploma in Multimedia students.', 'condition' => 'Used', 'subject_id' => 'DMM201', 'subject_category' => 'Elective Subject', 'status' => 'available', 'price' => 15.00, 'meeting_location' => 'Block B cafeteria', 'meeting_day' => 14, 'meeting_time' => '14:00:00', 'meeting_end_time' => '15:00:00'],
            ['key' => 'software-project', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Software Engineering Project Design', 'description' => 'A practical guide to requirements, architecture, testing, and project documentation for Bachelor of Software Engineering with Honours students.', 'condition' => 'Like New', 'subject_id' => 'SWE401', 'subject_category' => 'Final Year Project', 'status' => 'available', 'price' => 18.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 15, 'meeting_time' => '13:00:00', 'meeting_end_time' => '14:00:00'],
        ];

        $books = collect($bookRows)->mapWithKeys(function (array $row) use ($users) {
            $book = Book::updateOrCreate(
                ['user_id' => $users[$row['owner']]->id, 'title' => $row['title']],
                [
                    'description' => $row['description'],
                    'condition' => $row['condition'],
                    'subject_id' => $row['subject_id'],
                    'subject_category' => $row['subject_category'],
                    'image' => 'books/demo-cover.svg',
                    'status' => $row['status'],
                    'price' => $row['price'],
                    'meeting_location' => $row['meeting_location'],
                    'meeting_date' => now()->addDays($row['meeting_day'])->toDateString(),
                    'meeting_time' => $row['meeting_time'],
                    'meeting_end_time' => $row['meeting_end_time'],
                ]
            );

            return [$row['key'] => $book];
        });

        $requests = [
            ['book' => 'database', 'requester' => 'aina.demo@example.com', 'owner' => 'farah.demo@example.com', 'status' => 'approved', 'is_taken' => false, 'schedule_type' => 'seller'],
            ['book' => 'software', 'requester' => 'jason.demo@example.com', 'owner' => 'aina.demo@example.com', 'status' => 'completed', 'is_taken' => true, 'schedule_type' => 'seller'],
            ['book' => 'web', 'requester' => 'mei.demo@example.com', 'owner' => 'daniel.demo@example.com', 'status' => 'pending', 'is_taken' => false, 'schedule_type' => 'seller'],
            ['book' => 'calculus', 'requester' => 'farah.demo@example.com', 'owner' => 'daniel.demo@example.com', 'status' => 'rejected', 'is_taken' => false, 'schedule_type' => 'seller'],
        ];

        foreach ($requests as $row) {
            $bookRequest = BookRequest::updateOrCreate(
                [
                    'book_id' => $books[$row['book']]->id,
                    'requester_id' => $users[$row['requester']]->id,
                ],
                [
                    'owner_id' => $users[$row['owner']]->id,
                    'status' => $row['status'],
                    'schedule_type' => $row['schedule_type'],
                    'proposed_location' => $row['status'] === 'pending' ? 'Library entrance' : null,
                    'proposed_date' => $row['status'] === 'pending' ? now()->addDays(5)->toDateString() : null,
                    'proposed_time' => $row['status'] === 'pending' ? '14:00:00' : null,
                    'proposed_end_time' => $row['status'] === 'pending' ? '15:30:00' : null,
                ]
            );
            $bookRequest->is_taken = $row['is_taken'];
            $bookRequest->save();
        }

        $scheduleRows = [
            ['book' => 'algorithms', 'seller' => 'aina.demo@example.com', 'buyer' => null, 'status' => 'available'],
            ['book' => 'database', 'seller' => 'farah.demo@example.com', 'buyer' => 'aina.demo@example.com', 'status' => 'accepted'],
            ['book' => 'web', 'seller' => 'daniel.demo@example.com', 'buyer' => 'mei.demo@example.com', 'status' => 'requested'],
        ];

        foreach ($scheduleRows as $row) {
            BookSchedule::updateOrCreate(
                ['book_id' => $books[$row['book']]->id],
                [
                    'seller_id' => $users[$row['seller']]->id,
                    'buyer_id' => $row['buyer'] ? $users[$row['buyer']]->id : null,
                    'location' => $books[$row['book']]->meeting_location,
                    'meeting_date' => $books[$row['book']]->meeting_date,
                    'meeting_time' => $books[$row['book']]->meeting_time,
                    'meeting_end_time' => $books[$row['book']]->meeting_end_time,
                    'status' => $row['status'],
                    'proposed_location' => null,
                    'proposed_date' => null,
                    'proposed_time' => null,
                    'proposed_end_time' => null,
                ]
            );
        }

        SavedBook::firstOrCreate([
            'user_id' => $users['mei.demo@example.com']->id,
            'book_id' => $books['algorithms']->id,
        ]);
        SavedBook::firstOrCreate([
            'user_id' => $users['jason.demo@example.com']->id,
            'book_id' => $books['discrete']->id,
        ]);

        Review::updateOrCreate(
            [
                'book_id' => $books['software']->id,
                'user_id' => $users['jason.demo@example.com']->id,
            ],
            ['rating' => 5, 'comment' => 'Smooth exchange and the book was exactly as described.']
        );

        Report::updateOrCreate(
            [
                'book_id' => $books['networks']->id,
                'user_id' => $users['mei.demo@example.com']->id,
                'reason' => 'Listing information needs review',
            ],
            [
                'description' => 'Demo report for checking the admin review workflow.',
                'status' => 'pending',
            ]
        );

        $resolvedReport = Report::updateOrCreate(
            [
                'book_id' => $books['calculus']->id,
                'user_id' => $users['aina.demo@example.com']->id,
                'reason' => 'Resolved demo report',
            ],
            [
                'description' => 'Demo report to populate the resolved reports page.',
                'status' => 'resolved',
            ]
        );
        $resolvedReport->admin_review = 'Reviewed for demonstration purposes.';
        $resolvedReport->save();

        $this->command?->info('Demo data seeded. Demo accounts use the password: DemoPass123!');
    }
}
