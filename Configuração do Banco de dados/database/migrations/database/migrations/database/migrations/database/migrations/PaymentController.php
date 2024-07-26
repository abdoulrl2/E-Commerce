namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $request->input('amount') * 100,
            'currency' => 'usd',
            'source' => $request->input('stripeToken'),
            'description' => 'Order payment',
        ]);

        return redirect()->route('products.index')->withSuccess('Pagamento realizado com sucesso!');
    }
}
