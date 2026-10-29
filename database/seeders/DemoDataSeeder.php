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
            ['key' => 'algorithms', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Introduction to Algorithms', 'description' => 'A well-kept reference for algorithm design, sorting, graphs, and problem solving.', 'condition' => 'Like New', 'subject_id' => 'CSC301', 'status' => 'available', 'price' => 25.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 3, 'meeting_time' => '14:00:00', 'meeting_end_time' => '16:00:00'],
            ['key' => 'calculus', 'owner' => 'daniel.demo@example.com', 'title' => 'DEMO — Calculus: Early Transcendentals', 'description' => 'Calculus textbook with clear examples and some notes in the margins.', 'condition' => 'Used', 'subject_id' => 'MAT202', 'status' => 'available', 'price' => 15.00, 'meeting_location' => 'Block A student lounge', 'meeting_day' => 4, 'meeting_time' => '11:30:00', 'meeting_end_time' => '13:00:00'],
            ['key' => 'database', 'owner' => 'farah.demo@example.com', 'title' => 'DEMO — Database System Concepts', 'description' => 'Useful for SQL, relational database design, normalization, and transactions.', 'condition' => 'New', 'subject_id' => 'CSC315', 'status' => 'reserved', 'price' => 30.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 5, 'meeting_time' => '15:00:00', 'meeting_end_time' => '17:00:00'],
            ['key' => 'software', 'owner' => 'aina.demo@example.com', 'title' => 'DEMO — Software Engineering', 'description' => 'Covers requirements, design, testing, and software project management.', 'condition' => 'Like New', 'subject_id' => 'SWE301', 'status' => 'sold', 'price' => 20.00, 'meeting_location' => 'Block B cafeteria', 'meeting_day' => 2, 'meeting_time' => '13:00:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'networks', 'owner' => 'jason.demo@example.com', 'title' => 'DEMO — Computer Networking: A Top-Down Approach', 'description' => 'Networking fundamentals with chapters on HTTP, routing, and transport protocols.', 'condition' => 'Used', 'subject_id' => 'CSC322', 'status' => 'available', 'price' => 18.00, 'meeting_location' => 'Student affairs counter', 'meeting_day' => 6, 'meeting_time' => '10:00:00', 'meeting_end_time' => '11:30:00'],
            ['key' => 'discrete', 'owner' => 'mei.demo@example.com', 'title' => 'DEMO — Discrete Mathematics and Its Applications', 'description' => 'Topics include logic, proofs, combinatorics, graphs, and discrete probability.', 'condition' => 'Used', 'subject_id' => 'MAT210', 'status' => 'available', 'price' => 0.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 7, 'meeting_time' => '12:30:00', 'meeting_end_time' => '14:00:00'],
            ['key' => 'operating-systems', 'owner' => 'farah.demo@example.com', 'title' => 'DEMO — Operating System Concepts', 'description' => 'An introductory text on processes, memory, file systems, and concurrency.', 'condition' => 'Like New', 'subject_id' => 'CSC330', 'status' => 'available', 'price' => 22.00, 'meeting_location' => 'Block C study area', 'meeting_day' => 8, 'meeting_time' => '16:00:00', 'meeting_end_time' => '18:00:00'],
            ['key' => 'web', 'owner' => 'daniel.demo@example.com', 'title' => 'DEMO — Web Application Development', 'description' => 'Practical introduction to HTTP, web forms, databases, and application security.', 'condition' => 'New', 'subject_id' => 'WEB201', 'status' => 'available', 'price' => 12.00, 'meeting_location' => 'Main campus library lobby', 'meeting_day' => 9, 'meeting_time' => '14:30:00', 'meeting_end_time' => '16:00:00'],
        ];

        $books = collect($bookRows)->mapWithKeys(function (array $row) use ($users) {
            $book = Book::updateOrCreate(
                ['user_id' => $users[$row['owner']]->id, 'title' => $row['title']],
                [
                    'description' => $row['description'],
                    'condition' => $row['condition'],
                    'subject_id' => $row['subject_id'],
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
