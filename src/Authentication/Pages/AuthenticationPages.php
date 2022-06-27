<?php

namespace SudoBee\Cygnus\Authentication\Pages;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use SudoBee\Cygnus\Authentication\Operations\LogoutOperation;

class AuthenticationPages
{
	private static bool $enableRegistration = false;

	private static bool $enablePasswordReset = false;

	private static bool $enableUserEditPage = false;

	/**
	 * @param array<int, mixed>|string $authenticatedMiddlewares
	 * @param array<int, mixed>|string $guestMiddlewares
	 */
	public function __construct(
		private readonly array|string $authenticatedMiddlewares,
		private readonly array|string $guestMiddlewares
	) {
		//
	}

	/**
	 * @param array<int, mixed>|string $authenticatedMiddlewares
	 * @param array<int, mixed>|string $guestMiddlewares
	 * @return AuthenticationPages
	 */
	public static function make(
		array|string $authenticatedMiddlewares,
		array|string $guestMiddlewares
	): self {
		return new self(
			authenticatedMiddlewares: $authenticatedMiddlewares,
			guestMiddlewares: $guestMiddlewares
		);
	}

	public static function isRegistrationEnabled(): bool
	{
		return self::$enableRegistration;
	}

	public static function isPasswordResetEnabled(): bool
	{
		return self::$enablePasswordReset;
	}

	public static function isUserEditPageEnabled(): bool
	{
		return self::$enableUserEditPage;
	}

	/**
	 * @param bool $enable
	 * @return static
	 */
	public function enableRegistration(bool $enable = true)
	{
		self::$enableRegistration = $enable;

		return $this;
	}

	/**
	 * @param bool $enable
	 * @return static
	 */
	public function enablePasswordReset(bool $enable = true)
	{
		self::$enablePasswordReset = $enable;

		return $this;
	}

	/**
	 * @param bool $enable
	 * @return static
	 */
	public function enableUserEditPage(bool $enable = true)
	{
		self::$enableUserEditPage = $enable;

		return $this;
	}

	public function register(): void
	{
		Route::middleware($this->guestMiddlewares)->group(function () {
			LoginPage::register();

			if (self::isRegistrationEnabled()) {
				RegisterPage::register();
			}

			if (self::isPasswordResetEnabled()) {
				ForgotPasswordPage::register();
				ForgotPasswordEmailSentPage::register();
				ResetPasswordPage::register();
			}
		});

		Route::middleware($this->authenticatedMiddlewares)->group(function () {
			if (self::isUserEditPageEnabled()) {
				UserEditPage::register();
			}
		});

		LogoutOperation::register();

		Route::get("/", fn() => redirect(RouteServiceProvider::getHomepage()));
	}
}
