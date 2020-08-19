<?php

namespace app\controllers;

use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use Faker\Factory as FakerFactory;
use app\models\Member;

class CsvController extends Controller
{
    /** @var array */
    public static array $companies = [
        'Google',
        'Apple Inc.',
        'Facebook',
        'Microsoft Corporation',
        'Amazon.com Inc.',
        'Hewlett-Packard Company',
        'IBM Corp.',
        'Oracle Corporation',
        'Activision Blizzard',
        'Electronic Arts, Inc.',
        'Samsung Electronics',
        'Xiaomi Corporation',
        'Huawei Technologies Co. Ltd.',
        'Alibaba Group',
        'Tencent Holdings Ltd.',
    ];

    /** @var array */
    public static array $departments = [
        'Engineering & Design',
        'Operations & Support',
        'Product Management',
        'Developer Relations & Technical Solutions',
        'Sales & Account Management',
        'Product & Customer Support',
        'Sales Operations',
        'Business Strategy',
        'Legal & Government Relations',
        'Marketing & Communications',
        'Real Estate & Workplace Services',
        'Information Security',
        'Global Security'
    ];

    /** @var array */
    public static array $positions = [
        '.NET Developer',
        'Application Developer',
        'Application Support Analyst',
        'Applications Engineer',
        'Associate Developer',
        'Chief Information Officer',
        'Chief Technology Officer',
        'Computer Network Architect',
        'Computer Programmer',
        'Computer Systems Analyst',
        'Computer Systems Manager',
        'Computer and Information Research Scientist',
        'Computer and Information Systems Manager',
        'Customer Support Administrator',
        'Customer Support Specialist',
        'Desktop Support Manager',
        'Desktop Support Specialist',
        'Developer',
        'Director of Technology',
        'Front End Developer',
        'Help Desk Specialist',
        'Help Desk Technician',
        'IT Analyst',
        'IT Coordinator',
        'IT Director',
        'IT Manager',
        'IT Support Manager',
        'IT Support Specialist',
        'IT Systems Administrator',
        'Java Developer',
        'Junior Software Engineer',
        'Management Information Systems Director',
        'Network Administrator',
        'Network Architect',
        'Network Engineer',
        'Network Systems Administrator',
        'Network and Computer Systems Administrator',
        'Programmer',
        'Programmer Analyst',
        'Senior Applications Engineer',
        'Senior Network Architect',
        'Senior Network Engineer',
        'Senior Network System Administrator',
        'Senior Programmer',
        'Senior Programmer Analyst',
        'Senior Software Engineer',
        'Senior Support Specialist',
        'Senior System Administrator',
        'Senior System Analyst',
        'Senior System Architect',
        'Senior System Designer',
        'Senior Systems Software Engineer',
        'Senior Web Administrator',
        'Senior Web Developer',
        'Software Architect',
        'Software Developer',
        'Software Engineer',
        'Software Quality Assurance Analyst',
        'Support Specialist',
        'System Architect',
        'Systems Administrator',
        'Systems Analyst',
        'Systems Designer',
        'Systems Software Engineer',
        'Technical Operations Officer',
        'Technical Specialist',
        'Technical Support Engineer',
        'Technical Support Specialist',
        'Telecommunications Specialist',
        'Web Administrator',
        'Web Developer',
        'Webmaster'
    ];

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'factor' => count(self::$companies),
            'options' => [10, 50, 100]
        ]);
    }

    /**
     * Generates & saves sample CSV file
     *
     * @return void
     */
    public function actionGenerate(): void
    {
        // members for each company
        $count = (int) Yii::$app->request->post('count', 100);

        $faker = FakerFactory::create();

        $filename = 'sample-'.date('d-m-Y').'-'.time().'.csv';

        $separator = ';';

        $rows = [];

        foreach (self::$companies as $i => $company) {
            $rows[] = implode($separator, [
                $company,
                $faker->randomNumber(9),
                $faker->city.', '.$faker->streetAddress,
                $faker->sentence()
            ]);

            for ($j = 1; $j <= $count; $j++) {
                $country = $faker->country;
                $lastName = $faker->lastName;
                $familyId = sprintf(
                    '%s-%d',
                    strtoupper(substr($company, 0, 2)),
                    $faker->unique()->numberBetween(1000, 9999)
                );

                $required = [
                    $faker->randomElement(self::$departments),
                    $faker->randomElement(self::$positions),
                ];

                $member = array_merge($required, [
                    $familyId,
                    $faker->firstNameMale.' '.$lastName,
                    Member::ROLE_MEMBER,
                    Member::GENDER_MALE,
                    $this->getSampleBirthDate(rand(25, 35)),
                    $country,
                    $this->getSamplePassportNumber()
                ]);

                // member
                $rows[] = implode($separator, $member);

                $emptyValues = array_fill(0, count($required), '');

                // spouse
                if ($hasSpouse = rand(0, 1)) {
                    $rows[] = implode($separator, array_merge($emptyValues, [
                        $familyId,
                        $faker->firstNameFemale.' '.$lastName,
                        Member::ROLE_SPOUSE,
                        Member::GENDER_FEMALE,
                        $this->getSampleBirthDate(rand(25, 35)),
                        $country,
                        $this->getSamplePassportNumber()
                    ]));
                }

                // child
                if ($hasSpouse && rand(0, 1)) {
                    for ($k = 1; $k <= rand(1, 2); $k++) {
                        $gender = $faker->randomElement([
                            Member::GENDER_MALE,
                            Member::GENDER_FEMALE
                        ]);

                        $rows[] = implode($separator, array_merge($emptyValues, [
                            $familyId,
                            $faker->firstName(strtolower($gender)).' '.$lastName,
                            Member::ROLE_CHILD,
                            $gender,
                            $this->getSampleBirthDate(rand(1, 10)),
                            $country,
                            $this->getSamplePassportNumber()
                        ]));
                    }
                }
            }

            if ($i + 1 < count(self::$companies)) {
                $rows[] = '---';
            }
        }

        $content = implode(PHP_EOL, $rows);

        try {
            Yii::$app->response->sendContentAsFile($content, $filename, [
                'mimeType' => 'text/csv',
                'inline' => false
            ])->send();
        } catch (RangeNotSatisfiableHttpException $e) {
            // todo
        }
    }

    /**
     * @param int $interval
     * @return string
     */
    private function getSampleBirthDate($interval = 30): string
    {
        return FakerFactory::create()->dateTimeInInterval(
            '-'.$interval.' years',
            '+'.rand(1, 365).' days'
        )->format('Y-m-d');
    }

    /**
     * @return string
     */
    private function getSamplePassportNumber(): string
    {
        return strtoupper(FakerFactory::create()->bothify('??######'));
    }
}
