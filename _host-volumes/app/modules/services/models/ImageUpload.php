<?php

	namespace app\modules\services\models;


	use yii\base\Model;
	use yii\web\UploadedFile;

	/**
	 *
	 * @property string $folder
	 */
	class ImageUpload extends Model
	{
		public $image;

		public function rules()
		{
			return [
				[['image'], 'required'],
				[['image'], 'file', 'extensions' => 'jpg, png']
			];
		}

		public function uploadFile(UploadedFile $file, $currentImage)
		{
			$this->image = $file;

			if ($this->validate()) {

				$this->deleteCurrentImage($currentImage);

				return $this->saveImage();
			}
		}

		/**
		 * @return string
		 */
		public function getFolder(): string
		{
			return \Yii::getAlias('@web') . 'images/services/uploads/';
		}

		/**
		 * @return string
		 */
		private function generateFileName(): string
		{
			return strtolower(md5(uniqid($this->image->baseName))) . '.' . $this->image->extension;
		}

		/**
		 * @param $currentImage
		 */
		public function deleteCurrentImage($currentImage): void
		{
			if ($this->fileExists($currentImage))
				unlink($this->getFolder() . $currentImage);
		}

		/**
		 * @param $currentImage
		 * @return bool
		 */
		public function fileExists($currentImage)
		{
			if (!empty($currentImage) && $currentImage != null) {
				return file_exists($this->getFolder() . $currentImage);
			}
		}

		/**
		 * @return string
		 */
		public function saveImage(): string
		{
			$fileName = $this->generateFileName();

			if ($this->image->saveAs($this->getFolder() . $fileName)) {
				return $fileName;
			}
		}


	}