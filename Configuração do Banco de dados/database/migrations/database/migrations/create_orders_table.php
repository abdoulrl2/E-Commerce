public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('customer_email');
        $table->decimal('total_price', 8, 2);
        $table->timestamps();
    });
}
