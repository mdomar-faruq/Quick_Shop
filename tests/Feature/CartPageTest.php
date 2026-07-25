<?php

namespace Tests\Feature;

use Tests\TestCase;

class CartPageTest extends TestCase
{
 public function test_cart_page_is_available(): void
 {
  $response = $this->get('/cart');

  $response->assertStatus(200);
 }

 public function test_cart_page_contains_checkout_form_and_confirmation_ui(): void
 {
  $response = $this->get('/cart');

  $response->assertStatus(200);
  $response->assertSee('অর্ডার কনফার্ম করুন');
  $response->assertSee('checkout-form');
  $response->assertSee('confirmModal');
  $response->assertSee('cart-input');
 }
}
