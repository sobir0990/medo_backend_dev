<?php

use yii\db\Migration;

/**
 * Class m190125_071640_create_fake_data
 */
class m190615_071640_create_fake_data extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
//		$faker = \Faker\Factory::create('ru_RU');
//
//		for ($i = 2; $i <= 10; $i++) {
//			$gender = ($i % 2) ? 'male' : 'female';
//			$user = new \common\models\User();
//			$user->load(
//				[
//					'id' => $i,
//					'username' => $faker->userName,
//					'phone' => $faker->phoneNumber,
//					'email' => $faker->email,
//					'password_hash' => Yii::$app->security->generatePasswordHash('password_' . $i),
//					'status' => '10',
//				], '');
//			$user->save();
//			$last = $faker->lastName;
//			if ($i % 2 === 0) $last .= 'а';
//			$profile = new \common\models\Profile();
//			$profile->load(
//				[
//					'user_id' => $user->id,
//					'first_name' => $faker->firstName($gender),
//					'last_name' => $last,
//					'middle_name' => $faker->middleName($gender),
//					'gender' => ($i % 2) ?: 2,
//					'type' => $faker->boolean,
//					'region_id' => $faker->numberBetween(1, 14),
//					'city_id' => $faker->numberBetween(1, 224),
//					'status' => '2',
//				], '');
//			$profile->save();
//			echo "Profile" . $profile->id . " added" . PHP_EOL;
//			if ($faker->boolean(80)) {
//				$company = new \common\models\Company();
//				$company->load(
//					[
//						'profile_id' => $profile->id,
//						'name_uz' => $faker->words(3),
//						'name_ru' => $faker->company,
//						'description_uz' => $faker->sentences(2, true),
//						'description_ru' => $faker->sentences(2, true),
//						'phone' => $faker->phoneNumber,
//						'address' => $adrs = $faker->address,
//						'type' => $faker->numberBetween(1, 4),
//						'status' => '2',
//                        'city_id' => $faker->numberBetween(1,224),
//                        'page_uz' => $faker->paragraphs(2, true),
//                        'page_ru' => $faker->paragraphs(2, true),
//					], '');
//				$company->save();
//				echo 'Company ' . $company->id . ' added' . PHP_EOL;
//
//			}
//		}

	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->truncateTable('product');
		$this->truncateTable('company');
		$this->truncateTable('profile');
		$this->truncateTable('user');
		return false;
	}
}
