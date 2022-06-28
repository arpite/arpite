<?php

namespace Arpite\Arpite\Core\Utilities;

use Throwable;

class Notification
{
	public static function danger(
		string $description,
		string $title = "Something went wrong!"
	): void {
		self::show("danger", $title, $description);
	}

	public static function success(
		string $description,
		string $title = "Success!"
	): void {
		self::show("success", $title, $description);
	}

	/**
	 * @return array{type: string, title: string, description: string}|null
	 * @throws Throwable
	 */
	public static function getAndClear(): ?array
	{
		$notification = session()->get("notification", null);

		session()->remove("notification");

		return $notification;
	}

	private static function show(
		string $type,
		string $title,
		string $description
	): void {
		/**
		 * We use `put` instead of `flash` because when more
		 * than 1 redirects happen, the notification value gets
		 * lost.
		 */
		session()->put("notification", [
			"type" => $type,
			"title" => __($title),
			"description" => __($description),
		]);
	}
}
