<?php
namespace JS\JsFaq\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Jainish Senjaliya <jainish.online@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * FAQController
 */
class FAQController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * fAQRepository
	 *
	 * @var \JS\JsFaq\Domain\Repository\FAQRepository
	 * @inject
	 */
	protected $fAQRepository;

	/**
	 * fAQService
	 *
	 * @var \JS\JsFaq\Service\FAQService
	 * @inject
	 */
	protected $fAQService;

	/**
	 * action faq
	 *
	 * @return void
	 */
	public function faqAction() {


		$getData	= \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_jsfaq_faq');

		$detail 	= 0;

		if(isset($getData['faq']) && $getData['faq']>0){
			$detail = $getData['faq'];
		}

		$template = $this->fAQService->missingConfiguration($this->settings);

		$faq = $this->fAQRepository->getFAQData($this->settings,$detail);

		$categoryGroupWise = 0;

		if($this->settings['displayFAQ']=="categoryGroupWise"){
			$categoryGroupWise = 1;
			$faq = $this->fAQRepository->getFAQCategoryData($faq);
		}

		if(count($faq)==0){
			$template = 3;
		}

		$faqArr = array('faq' =>$faq , 'setting' => $this->settings );

		$this->view->assign('FAQ', $faqArr);
		
		$this->view->assign('template', $template);

		$this->view->assign('detail', $detail);

		$this->view->assign('categoryGroupWise', $categoryGroupWise);
		
		// Include Additional Data
		$this->fAQService->includeAdditionalData($this->settings);
	}

}
?>