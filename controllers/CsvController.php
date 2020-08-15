<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;
use Faker\Factory as FakerFactory;
use app\models\Member;

class CsvController extends Controller
{
    /** @var array */
    public static $companies = [
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
    public static $departments = [
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
    public static $positions = [
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
     * Generates & saves sample CSV file
     *
     * @param int $count
     * @param int $save
     * @return void|string
     */
    public function actionIndex($count = 15, $save = 0)
    {
        $faker = FakerFactory::create();

        $filename = 'sample-'.date('d-m-Y').'-'.time().'.csv';

        $per = floor($count / count(self::$companies));

        $separator = ';';

        $rows = [];

        foreach (self::$companies as $i => $company) {
            $rows[] = implode($separator, [
                $company,
                $faker->randomNumber(9),
                $faker->city.', '.$faker->streetAddress,
                $faker->sentence()
            ]);

            for ($j = 1; $j <= $per; $j++) {
                $nationality = $faker->country;
                $lastName = $faker->lastName;

                $required = [
                    $faker->randomElement(self::$departments),
                    $faker->randomElement(self::$positions),
                ];

                $member = array_merge($required, [
                    $faker->firstNameMale.' '.$lastName,
                    Member::ROLE_MEMBER,
                    Member::GENDER_MALE,
                    $this->getSampleBirthDate(rand(25, 35)),
                    $nationality,
                    $this->getSamplePassportNumber()
                ]);

                // member
                $rows[] = implode($separator, $member);

                $emptyValues = array_fill(0, count($required), '');

                // spouse
                if ($hasSpouse = rand(0, 1)) {
                    $rows[] = implode($separator, array_merge($emptyValues, [
                        $faker->firstNameFemale.' '.$lastName,
                        Member::ROLE_SPOUSE,
                        Member::GENDER_FEMALE,
                        $this->getSampleBirthDate(rand(25, 35)),
                        $nationality,
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
                            $faker->firstName(strtolower($gender)).' '.$lastName,
                            Member::ROLE_CHILD,
                            $gender,
                            $this->getSampleBirthDate(rand(1, 10)),
                            $nationality,
                            $this->getSamplePassportNumber()
                        ]));
                    }
                }

                $rows[] = $separator;
            }

            $rows[] = PHP_EOL;
        }

        $content = implode(PHP_EOL, $rows);

        if ($save) {
            try {
                Yii::$app->response->sendContentAsFile($content, $filename, [
                    'mimeType' => 'text/csv',
                    'inline' => false
                ])->send();
            } catch (RangeNotSatisfiableHttpException $e) {
                echo $e->getMessage();
            }
        } else {
            return $this->render('index', ['content' => $content]);
        }
    }

    /**
     * @param int $interval
     * @return string
     */
    private function getSampleBirthDate($interval = 30) {
        return FakerFactory::create()->dateTimeInInterval(
            '-'.$interval.' years',
            '+'.rand(1, 365).' days'
        )->format('Y-m-d');
    }

    /**
     * @return string
     */
    private function getSamplePassportNumber() {
        return strtoupper(FakerFactory::create()->bothify('??######'));
    }
}
