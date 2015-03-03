<?php

class ModeloRelatorio {
	//A4 210mm x 297mm	595.28 841.89
	private $pdfToClone;
	private $pageToClone;
	private $pdf;
	private $page;
	private $titleLine = 820;
	private $legendLine = 790;
	private $columnSpace = 5;
	private $firstLine = 775;
	private $lastLine = 40;
	private $columnRodape = 470;
	private $lineRodape = 15;
	private $lineLength = 11;
	private $countPag = 0;
	private $linha = 0;
	private $isFirstPage = true;
	private $isLegenda = true;

	public function __construct() {
		Zend_Loader::loadClass('Zend_Pdf');

		$this->pdfToClone = new Zend_Pdf();
		$this->pdfToClone = Zend_Pdf::load('../library/templateRelatorio.pdf');

		$this->pageToClone = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		$this->pageToClone = clone $this->pdfToClone->pages[0];
		$this->pageToClone->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);

		$this->pdf = new Zend_Pdf();
		$this->page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

		$this->linha = $this->firstLine;
	}

	public function setTitulo( $title ) {
		$textColumnposition = $this->getCenterPosition(
			$title,
			$this->pageToClone->getWidth(),
			$this->pageToClone->getFont(),
			$this->pageToClone->getFontSize() );
			$this->pageToClone->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);
		$this->pageToClone->drawText( $title,  $textColumnposition, $this->titleLine ,'UTF-8');
	}

	public function setLegendaOff() {
		$this->isLegenda = false;

		$this->linha = $this->legendLine;
	}

	public function setLegendaCenter( $columnPosition, $columnLargura, $text ) {
		$textColumnposition = $this->getCenterPosition(
			$text,
			$columnLargura,
			$this->pageToClone->getFont(),
			$this->pageToClone->getFontSize() );
			$this->pageToClone->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);

		$this->pageToClone->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
		$this->pageToClone->drawText( $text,  $columnPosition + $textColumnposition, $this->legendLine ,'UTF-8');
	}

	public function setLegenda( $columnPosition, $text ) {
		$this->pageToClone->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
		$this->pageToClone->drawText( $text,  $columnPosition, $this->legendLine ,'UTF-8');
	}

	public function setValue( $columnPosition, $text ) {
		if ( $this->isFirstPage ) {
			$this->setNewPage();
			$this->isFirstPage = FALSE;
		}

		$this->page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 9);
		$this->page->drawText( $text,  $columnPosition, $this->linha ,'UTF-8');
	}

	public function setLegValue( $columnPosition, $leg, $text ) {
		if ( $this->isFirstPage ) {
			$this->setNewPage();
			$this->isFirstPage = FALSE;
		}

		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.6));
		$this->page->drawText( $leg,  $columnPosition, $this->linha, 'UTF-8' );

		$tw = $this->getTextWidth($leg, $this->page->getFont(), $this->page->getFontSize() );

		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.0));
		$this->page->drawText( $text,  $columnPosition + $tw, $this->linha ,'UTF-8');
	}

	public function setLegValueAlinhadoDireita( $columnPosition, $columnLargura, $leg, $text ) {
		if ( $this->isFirstPage ) {
			$this->setNewPage();
			$this->isFirstPage = FALSE;
		}

		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.6));
		$this->page->drawText( $leg,  $columnPosition, $this->linha ,'UTF-8');

// 		$tw = $this->getTextWidth($leg, $this->page->getFont(), $this->page->getFontSize() );

		$tw = $this->getRightPosition( $text, $columnLargura, $this->page->getFont(), $this->page->getFontSize() );

		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.0));
		$this->page->drawText( $text,  $columnPosition + $tw, $this->linha,'UTF-8' );
	}

	public function setLegAlinhadoDireita( $columnPosition,  $columnLargura, $text ) {
		if ( $this->isFirstPage ) {
			$this->setNewPage();
			$this->isFirstPage = FALSE;
		}

		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.6));
		$this->page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 9);
		$pos = $this->getRightPosition( $text, $columnLargura, $this->page->getFont(), $this->page->getFontSize() );
		$this->page->drawText( $text,  $columnPosition + $pos, $this->linha,'UTF-8' );
		$this->page->setFillColor(new Zend_Pdf_Color_GrayScale(0.0));
	}


	public function setValueAlinhadoDireita( $columnPosition,  $columnLargura, $text ) {
		if ( $this->isFirstPage ) {
			$this->setNewPage();
			$this->isFirstPage = FALSE;
		}

		$this->page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 9);
		$pos = $this->getRightPosition( $text, $columnLargura, $this->page->getFont(), $this->page->getFontSize() );
		$this->page->drawText( $text,  $columnPosition + $pos, $this->linha ,'UTF-8');
	}

	public function setNewLine() {
		if ( $this->linha <= $this->lastLine ) {
			if ( $this->isLegenda ) {
				$this->linha = $this->firstLine;
			} else {
				$this->linha = $this->legendLine;
			}
			$this->setNewPage();
		} else {
			$this->linha = $this->linha - $this->lineLength;
		}
	}

	private function setNewPage() {
		if ( $this->isFirstPage==FALSE ) {
			$this->pdf->pages[] = $this->page;
		}

		date_default_timezone_set("Brazil/East");
		$this->page = clone $this->pageToClone;
		$this->page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 9);
		$this->countPag++;

		$text = date("d/m/Y H:m").' - Página: ' . $this->countPag;
		$column = $this-> getRightPosition(
			$text,
			100,
			$this->page->getFont(),
			$this->page->getFontSize() );

		$this->page->drawText( $text,  $this->columnRodape+$column, $this->lineRodape ,'UTF-8');
	}

	public function getModelRelatorio() {
		$this->pdfToClone->pages[0] = $this->pageToClone;

		return $this->pdfToClone->pages[0];
	}

// 	public function getPage() {
// 		$this->setNewPage()
//
// 		return $this->page;
// 	}

	public function getRelatorio() {
		$this->pdf->pages[] = $this->page;

	 	return $this->pdf;
	}

	private function getTextWidth($text, Zend_Pdf_Resource_Font $font, $font_size) {
		$drawing_text = iconv('UTF-8', 'UTF-16', $text);
		$characters = array();
		for ($i = 0; $i < strlen($drawing_text); $i++) {
			$characters[] = (ord($drawing_text[$i++]) << 8) | ord($drawing_text[$i]);
		}
		$glyphs = $font->glyphNumbersForCharacters($characters);
		$widths = $font->widthsForGlyphs($glyphs);
		$text_width = (array_sum($widths) / $font->getUnitsPerEm()) * $font_size;

		return $text_width;
	}

	public function getRightPosition($text, $width, Zend_Pdf_Resource_Font $font, $font_size) {
		$textWidth = $this->getTextWidth($text, $font, $font_size);

		return $width -  $textWidth - $this->columnSpace;
	}

	public function getCenterPosition($text, $width, Zend_Pdf_Resource_Font $font, $font_size) {
		$textWidth = $this->getTextWidth($text, $font, $font_size);

		return ($width/2) - ($textWidth/2);
	}

	public function getFirstLine() {
		return $this->firstLine;
	}

	public function getLastLine() {
		return $this->lastLine;
	}

	public function getColumnRodape() {
		return $this->columnRodape;
	}

	public function getLineRodape() {
		return $this->lineRodape;
	}

	public function getTextLineLength() {
		return $this->lineLength;
	}

	public function getLegendLine() {
		return $this->lege;
	}

	public function getLinha() {
		return $this->linha;
	}

	public function setForceNewPage() {
		$this->linha = $this->lineRodape;

		if ( $this->linha <= $this->lastLine ) {
			if ( $this->isLegenda ) {
				$this->linha = $this->firstLine;
			} else {
				$this->linha = $this->legendLine;
			}
			$this->setNewPage();
		}
	}
}

?>