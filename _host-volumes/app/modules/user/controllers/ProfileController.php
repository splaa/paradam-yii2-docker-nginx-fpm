<?php
// paradam.me.loc/ProfileController.php

	namespace app\modules\user\controllers;


	use app\modules\admin\models\User;
	use app\modules\user\forms\DateChangeForm;
	use app\modules\user\forms\DescriptionChangeForm;
	use app\modules\user\forms\LanguageAddForm;
	use app\modules\user\forms\LinkChangeForm;
	use app\modules\user\forms\NameChangeForm;
	use app\modules\user\forms\PasswordChangeForm;
	use app\modules\user\forms\ProfileUpdateForm;
	use app\modules\user\forms\TelephoneChangeForm;
	use app\modules\user\forms\UploadAvatar;
	use app\modules\user\forms\UploadCover;
	use app\modules\user\forms\UserNameChangeForm;
	use app\modules\user\models\Activity;
	use yii\data\ActiveDataProvider;
	use yii\imagine\Image;
	use Yii;
	use yii\filters\AccessControl;
	use yii\web\Controller;
	use yii\web\UploadedFile;

	class ProfileController extends UserController
	{
		public function actionIndex()
		{
			return $this->render('index', [
				'model' => $this->findModel(),
			]);
		}
		
		private function findModel()
		{
			return User::findOne(Yii::$app->user->identity->getId());
		}
		
		
		public function actionUpdate()
		{
			$user = $this->findModel();
			$model = new ProfileUpdateForm($user);
			
			if ($model->load(Yii::$app->request->post()) && $model->update()) {
				return $this->redirect(['index']);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}
		
		public function actionPasswordChange()
		{
			$user = $this->findModel();
			$model = new PasswordChangeForm($user);
			
			if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
				return $this->redirect(['index']);
			} else {
				return $this->render('passwordChange', [
					'model' => $model,
				]);
			}
		}

		public function actionUploadAvatar()
		{
			$model = new UploadAvatar();

			if (Yii::$app->request->isPost) {
				$model->file = UploadedFile::getInstance($model, 'file');

				if ($model->file && $model->validate()) {
					$model->file->saveAs('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_ORIGINAL . '.' . $model->file->extension);
					// Generate Small Avatar
					Image::thumbnail('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_ORIGINAL . '.' . $model->file->extension, User::SIZE_AVATAR_SMALL, User::SIZE_AVATAR_SMALL)
						->save('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_SMALL . '.' . $model->file->extension);
					// Generate Medium Avatar
					Image::thumbnail('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_ORIGINAL . '.' . $model->file->extension, User::SIZE_AVATAR_MEDIUM, User::SIZE_AVATAR_MEDIUM)
						->save('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_MEDIUM . '.' . $model->file->extension);
					// Generate Big Avatar
					Image::thumbnail('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_ORIGINAL . '.' . $model->file->extension, User::SIZE_AVATAR_BIG, User::SIZE_AVATAR_BIG)
						->save('images/user/avatar/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_BIG . '.' . $model->file->extension);
				}
			}

			return $this->render('avatar', [
				'model' => $model
			]);
		}

		public function actionUploadCover()
		{
			$model = new UploadCover();

			if (Yii::$app->request->isPost) {
				$model->file = UploadedFile::getInstance($model, 'file');

				if ($model->file && $model->validate()) {
					$model->file->saveAs('images/user/cover/' . Yii::$app->user->identity->getId() . '-' . User::SIZE_AVATAR_ORIGINAL . '.' . $model->file->extension);
				}
			}

			return $this->render('cover', [
				'model' => $model
			]);
		}

		public function actionBalance()
		{
			$model = Activity::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC]);

			$dataProvider = new ActiveDataProvider([
				'query' => $model,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			return $this->render('balance', [
				'model' => $model,
				'dataProvider' => $dataProvider
			]);
		}

		public function actionTelephoneChange()
		{
			$user = $this->findModel();
			$model = new TelephoneChangeForm($user);

			if ($model->load(Yii::$app->request->post()) && $model->changeTelephone()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Телефон успешно изменён.');

				return $this->refresh();
			} else {
				return $this->render('telephoneChange', [
					'model' => $model,
				]);
			}
		}

		public function actionNameChange()
		{
			$user = $this->findModel();
			$model = new NameChangeForm($user);

			if ($model->load(Yii::$app->request->post()) && $model->changeName()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Имя успешно изменёно.');

				return $this->refresh();
			} else {
				return $this->render('nameChange', [
					'model' => $model,
				]);
			}
		}

		public function actionUserNameChange()
		{
			$user = $this->findModel();
			$model = new UserNameChangeForm($user);

			if ($model->load(Yii::$app->request->post()) && $model->changeUserName()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Username успешно изменёно.');

				return $this->refresh();
			} else {
				return $this->render('userNameChange', [
					'model' => $model,
				]);
			}
		}

		public function actionDescriptionChange()
		{
			$user = $this->findModel();
			$model = new DescriptionChangeForm($user);

			if ($model->load(Yii::$app->request->post()) && $model->changeDescription()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Description успешно изменёно.');

				return $this->redirect(['index']);
			} else {
				return $this->render('descriptionChange', [
					'model' => $model,
				]);
			}
		}

		public function actionLinkChange()
		{
			$user = $this->findModel();
			$model = new LinkChangeForm($user);

			if ($model->load(Yii::$app->request->post()) && $model->changeLink()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Link успешно изменёно.');

				return $this->redirect(['index']);
			} else {
				return $this->render('linkChange', [
					'model' => $model,
				]);
			}
		}

		public function actionDateChange()
		{
			$user = $this->findModel();
			$model = new DateChangeForm($user);

			if ($user->birthday_change == 1) {
				Yii::$app->getSession()->setFlash('error', 'Ошибка! Дата рождения уже была изменена рание.');

				return $this->redirect('/user/profile/');
			} else {
				if ($model->load(Yii::$app->request->post()) && $model->changeDate()) {
					Yii::$app->getSession()->setFlash('success', 'Спасибо! Дата рождения успешно изменёно.');

					return $this->redirect('/user/profile/');
				} else {
					return $this->render('dateChange', [
						'model' => $model,
					]);
				}
			}
		}

		public function actionAddLanguages()
		{
			$user = $this->findModel();
			$model = new LanguageAddForm($user);
			$languages = $this->getLanguages();

			if ($model->load(Yii::$app->request->post()) && $model->addLanguages()) {
				Yii::$app->getSession()->setFlash('success', 'Спасибо! Языки успешно добавлены.');

				return $this->redirect(['index']);
			} else {
				return $this->render('addLanguages', [
					'model' => $model,
					'languages'  => $languages
				]);
			}
		}
		
		private function getLanguages() {
			$languages = [];
			$temp = [];

			if (file_exists(Yii::getAlias('@languages') . '/languages.all.min.json')) {
				$temp = file_get_contents(Yii::getAlias('@languages') . '/languages.all.min.json');
			}
			
			if ($temp) {
				$temp = json_decode($temp, true);
				foreach ($temp as $item) {
					$languages[$item['native']] = $item['native'];
				}
			}

			return $languages;
		}
	}