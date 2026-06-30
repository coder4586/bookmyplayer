<?php
namespace App\Http\Controllers\Static;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Adm_support_ticket;
use Illuminate\Http\Request;

class OurServices extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  public function index(Request $request)
  {


    $data = array(
      "title" => 'Buy Professional Sports Services | Coach Connections, Product Promotions, Venue Rentals',
      "des" => 'Explore our professional sports services, including Bulk Coach Connection, product promotion, banner advertising, tournament postings, venue rentals, and international marketing. Boost visibility and streamline bookings with BookMyPlayer’s curated service plans.',
      "keywords" => 'Bulk coach connection, sports product promotion, venue rentals, tournament promotion, featured listings, banner ads, sports campaign awareness, international sports marketing, BookMyPlayer services',
      "breadcrumbs" => [],
      "url" => 'https://www.bookmyplayer.com/buy-our-services'
    );
    return view('static.buy_our_services')->with('data', $data);
  }

  public function buyServiceRequest(Request $request)
  {
    try {
      $userId = session()->get('userId');

      $validatedData = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'email' => 'required|string',
        'phone' => 'required|string',
        'service' => 'required|string',
      ]);

      if (in_array($validatedData['email'], ['registry-help@registry.godaddy', 'carl87moorezht@hotmail.com', 'ronnie.church@msn.com','yjdisantoyjdissemin@gmail.com','morrismi1@outlook.com'])) {
        return response()->json(['status' => 'success', 'message' => 'We will contact you soon']);
      }

      if (array_filter(['spam', 'scam', 'fraud', 'illegal','https://'], fn($word) => stripos($validatedData['description'], $word) !== false)) {
        return response()->json(['status' => 'success', 'message' => 'We will contact you soon']);
      }

      $validatedData['category'] = 'buy-services';
      $ticket = new Adm_support_ticket();
      $ticket->email = $validatedData['email'];
      $ticket->name = $validatedData['name'];
      $ticket->phone = $validatedData['phone'];
      $ticket->description = $validatedData['description'];
      $ticket->user_id = $userId;
      $ticket->status = "waiting for support";
      $ticket->category = $validatedData['category'];
      $ticket->title = "want to buy services";

      if ($ticket->save()) {
        $sub = "Buy Our Service - {$validatedData['service']}";
        sendWBuyServiceRequestEmail($validatedData['name'], $validatedData['phone'], $validatedData['email'], $validatedData['description'], $sub);
        $response = ['status' => 'success', 'message' => 'We will contact you soon'];
      } else {
        $response = ['status' => 'error', 'message' => 'Failed to create support ticket'];
      }

      return $request->expectsJson()
        ? response()->json($response)
        : redirect()->back()->with($response['status'] . '_message_create_buy_service', $response['message']);
    } catch (\Exception $e) {
      $response = ['status' => 'error', 'message' => $e->getMessage()];

      return $request->expectsJson()
        ? response()->json($response)
        : redirect()->back()->with('error_message_create_buy_service', $e->getMessage());
    }
  }



}
