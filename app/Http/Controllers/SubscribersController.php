<?php

namespace App\Http\Controllers;


use Validator;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;



class SubscribersController extends Controller
{
    //




    public function shwoallsubs()
    {
        $items = Subscribers::all();

        if($items->isNotEmpty()){
            return response()->json([
                'success' => true,
                'message' => 'Subscribers Found Successfully',
                'data' => $items
            ], 200);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Subscribers Not Found Successfully',
            ], 404);

        }
        

     //   return view('subscribers.index', compact('items'));
    }

    public function addsubs(Request $request)
    {
            $input = $request->all();

            $validator = Validator::make($input, [
                'email' => 'required|email',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'isp' => 'nullable|string|max:255',
                'optin_date' => 'required|date',
                'ip_address' => 'nullable|ip',
                'referring_url' => 'nullable|string|max:512',
                'vertical' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:25',
                'city' => 'nullable|string|max:255',
                'device' => 'nullable|string|max:255',
                'bouncecount' => 'integer|min:0',
            ]);
        
            

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please see errors parameter for all errors.',
                    'errors' => $validator->errors()
                ]);
            }
    
           // $this->subscribersRepository->create($data);
           $subscribers = new Subscribers();
          // dd($subscribers);
           $subscribers->email = $request->email;
           $subscribers->first_name = $request->first_name;
           $subscribers->last_name = $request->last_name;
           $subscribers->isp = $request->isp;
           $subscribers->optin_date = $request->optin_date;
           $subscribers->ip_address = $request->ip_address;
           $subscribers->referring_url = $request->referring_url;
           $subscribers->vertical = $request->vertical;
           $subscribers->country = $request->country;
           $subscribers->state = $request->state;
           $subscribers->zip_code = $request->zip_code;
           $subscribers->city = $request->city;
           $subscribers->device = $request->device;
           $subscribers->bouncecount = $request->bouncecount;
           
           $subscribers->save();

            // return response()->json(['msg' => 'Subscriber Created Successful', 'status' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Subscribers Added Successfully'
            ], 200);
        } 
        
        
    



    public function update_subs(Request $request, $id)
    {
        try {
             $input = $request->all();

            $validator = Validator::make($input, [
                'email' => 'required|email',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'isp' => 'nullable|string|max:255',
                'optin_date' => 'required|date',
                'ip_address' => 'nullable|ip',
                'referring_url' => 'nullable|string|max:512',
                'vertical' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:25',
                'city' => 'nullable|string|max:255',
                'device' => 'nullable|string|max:255',
                'bouncecount' => 'integer|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please see errors parameter for all errors.',
                    'errors' => $validator->errors()
                ]);
            }

            //$this->subscribersRepository->update($id, $data);

            $subscribers = new Subscribers();
            $subscribers = Subscribers::find($id);
            $subscribers->email = $request->email;
            $subscribers->first_name = $request->first_name;
            $subscribers->last_name = $request->last_name;
            $subscribers->isp = $request->isp;
            $subscribers->optin_date = $request->optin_date;
            $subscribers->ip_address = $request->ip_address;
            $subscribers->referring_url = $request->referring_url;
            $subscribers->vertical = $request->vertical;
            $subscribers->country = $request->country;
            $subscribers->state = $request->state;
            $subscribers->zip_code = $request->zip_code;
            $subscribers->city = $request->city;
            $subscribers->device = $request->device;
            $subscribers->bouncecount = $request->bouncecount;
            $subscribers->save(); 
           
         //   return response()->json(['msg' => 'List Updated Successfully', 'status' => 1]);
         return response()->json([
            'success' => true,
            'message' => 'Subscribers ->'.$id.'-> Update Successfully'
        ], 200);
        }
        catch (ValidationException $e) {
            //return response()->json(['error' => $validator->errors()->all(), 'status' => 2]);

            return response()->json([
                'success' => true,
                'message' => 'Subscribers ->'.$id.'-> Updated Not Done',
                'Exception' => $e
             ], 200);
       
        }


        
    }



    public function show_single_subs(Request $request, $id)
    {
        $subscribers = Subscribers::where('id', $id)->get();
        // $ids = $request->input('ids', []); // via injected instance of Request
        // $items1 = items::whereIn('id', explode(',', $id))->get();
        // $items1 = items::whereIn('id', explode(',', $id->$request->get()));

        if ($subscribers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Subscribers Details Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscribers Details Found',
            'Pricing' => $subscribers
        ], 200);
    }
    

    public function destroy_subs($id)
    {
        $subscribers = Subscribers::find($id);
        if(!$subscribers==null){

            $subscribers->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subscribers Number->' . $id . '->Remove Successfully Done.'
            ], 200);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Something Went Wront Or Subscriber Not Found'
            ], 200);
        }
        
    }







}
