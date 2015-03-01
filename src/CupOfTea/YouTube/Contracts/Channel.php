<?php namespace CupOfTea\YouTube\Contracts;

interface Channel {

	/**
	 * Get the unique identifier for the channel.
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * Get the title for the channel.
	 *
	 * @return string
	 */
	public function getTitle();

	/**
	 * Get the thumbnail URLs for the channel.
	 *
	 * @return string
	 */
	public function getThumbnail();

}
