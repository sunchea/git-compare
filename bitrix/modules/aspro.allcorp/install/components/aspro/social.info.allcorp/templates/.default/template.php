<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?if( !empty( $arParams["VK"] ) ){?>
	<a href="<?=$arParams["VK"]?>" target="_blank" >
		<img border="0" src="/images/vk.png" alt="ВКонтакте" title="ВКонтакте" />
	</a>
<?}?>
<?if( !empty( $arParams["FACEBOOK"] ) ){?>
	<a href="<?=$arParams["FACEBOOK"]?>" target="_blank">
		<img border="0" src="/images/facebook.png" alt="Facebook" title="Facebook" />
	</a>
<?}?>
<?if( !empty( $arParams["TWITTER"] ) ){?>
	<a href="<?=$arParams["TWITTER"]?>" target="_blank">
		<img border="0" src="/images/twitter.png" alt="Twitter" title="Twitter" /> 
	</a>
<?}?>
<?if( !empty( $arParams["ODNOKLASSNIKI"] ) ){?>
	<a href="<?=$arParams["ODNOKLASSNIKI"]?>" target="_blank">
		<img border="0" src="/images/odnoklassniki.png" alt="Одноклассники" title="Одноклассники" /> 
	</a>
<?}?>
<?if( !empty( $arParams["MAILRU"] ) ){?>
	<a href="<?=$arParams["MAILRU"]?>" target="_blank">
		<img border="0" src="/images/mailru.png" alt="MailRu" title="MailRu" /> 
	</a>
<?}?>
<?if( !empty( $arParams["LIVEJOURNAL"] ) ){?>
	<a href="<?=$arParams["LIVEJOURNAL"]?>" target="_blank">
		<img border="0" src="/images/livejournal.png" alt="LiveJournal" title="LiveJournal" /> 
	</a>
<?}?>