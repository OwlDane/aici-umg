<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk Class Schedules
 * 
 * Creates sample schedules untuk setiap class:
 * - 2-3 batches per class
 * - Different start dates
 * - Realistic schedule info
 */
class ClassScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = ClassModel::all();

        foreach ($classes as $class) {
            // Create 2-3 schedules per class
            $scheduleCount = rand(2, 3);

            for ($i = 1; $i <= $scheduleCount; $i++) {
                $startDate = Carbon::now()->addWeeks($i * 2); // Stagger start dates
                $endDate = $startDate->copy()->addWeeks($class->program->duration_weeks ?? 8);

                // Determine day of week based on batch
                $dayOfWeek = match($i) {
                    1 => 'Senin,Rabu',
                    2 => 'Selasa,Kamis',
                    default => 'Sabtu',
                };

                // Determine time based on education level
                [$startTime, $endTime] = $this->getTimeSlot($class->program->education_level, $i);

                ClassSchedule::create([
                    'class_id' => $class->id,
                    'batch_name' => "Batch {$i} - " . $startDate->format('F Y'),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'day_of_week' => $dayOfWeek,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'location' => $this->getLocation($i),
                    'instructor_name' => $this->getInstructorName(),
                    'capacity' => 20,
                    'enrolled_count' => 0,
                    'is_available' => true,
                    'notes' => 'Kelas akan dimulai tepat waktu. Mohon datang 10 menit sebelumnya.',
                ]);
            }
        }

        $this->command->info('Class schedules seeded successfully!');
    }

    /**
     * Get time slot based on education level and batch
     * 
     * @param string $educationLevel
     * @param int $batch
     * @return array [start_time, end_time]
     */
    protected function getTimeSlot(string $educationLevel, int $batch): array
    {
        return match($educationLevel) {
            'sd_mi' => match($batch) {
                1 => ['13:00:00', '15:00:00'], // Afternoon
                2 => ['15:30:00', '17:30:00'], // Late afternoon
                default => ['09:00:00', '11:00:00'], // Weekend morning
            },
            'smp_mts' => match($batch) {
                1 => ['15:00:00', '17:30:00'], // After school
                2 => ['16:00:00', '18:30:00'], // Evening
                default => ['13:00:00', '16:00:00'], // Weekend afternoon
            },
            'sma_ma_smk' => match($batch) {
                1 => ['16:00:00', '19:00:00'], // Evening
                2 => ['18:00:00', '21:00:00'], // Night
                default => ['09:00:00', '13:00:00'], // Weekend morning
            },
            default => ['09:00:00', '12:00:00'],
        };
    }

    /**
     * Get location based on batch
     * 
     * @param int $batch
     * @return string
     */
    protected function getLocation(int $batch): string
    {
        $locations = [
            'Lab AI 1 - Gedung FMIPA UI Lantai 4',
            'Lab AI 2 - Gedung FMIPA UI Lantai 4',
            'Lab AI 3 - Gedung FMIPA UI Lantai 4',
        ];

        return $locations[($batch - 1) % count($locations)];
    }

    /**
     * Get random instructor name
     * 
     * @return string
     */
    protected function getInstructorName(): string
    {
        $instructors = [
            'Dr. Ahmad Fauzi, M.Kom',
            'Siti Nurhaliza, S.Kom, M.T',
            'Budi Santoso, S.T, M.Sc',
            'Rina Wijaya, S.Kom, M.Kom',
            'Dedi Kurniawan, S.T, M.T',
            'Maya Sari, S.Kom, M.Sc',
        ];

        return $instructors[array_rand($instructors)];
    }
}
