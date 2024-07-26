namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }
}
