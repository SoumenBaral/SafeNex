<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Upazila;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = $this->getData();

        foreach ($districts as $d) {
            $district = District::firstOrCreate(
                ['name' => $d['name']],
                ['name_bn' => $d['name_bn'], 'lat' => $d['lat'], 'lng' => $d['lng']]
            );

            foreach ($d['upazilas'] as $u) {
                Upazila::firstOrCreate(
                    ['district_id' => $district->id, 'name' => $u['name']],
                    ['name_bn' => $u['name_bn'], 'lat' => $u['lat'] ?? null, 'lng' => $u['lng'] ?? null]
                );
            }
        }
    }

    private function getData(): array
    {
        return [
            // --- Barishal Division ---
            [
                'name' => 'Barguna', 'name_bn' => 'বরগুনা', 'lat' => 22.1530, 'lng' => 90.1266,
                'upazilas' => [
                    ['name' => 'Amtali', 'name_bn' => 'আমতলী', 'lat' => 22.1141, 'lng' => 90.2312],
                    ['name' => 'Bamna', 'name_bn' => 'বামনা', 'lat' => 22.2012, 'lng' => 90.0389],
                    ['name' => 'Barguna Sadar', 'name_bn' => 'বরগুনা সদর', 'lat' => 22.1530, 'lng' => 90.1266],
                    ['name' => 'Betagi', 'name_bn' => 'বেতাগী', 'lat' => 22.2911, 'lng' => 90.1718],
                    ['name' => 'Patharghata', 'name_bn' => 'পাথরঘাটা', 'lat' => 21.9716, 'lng' => 90.0803],
                    ['name' => 'Taltali', 'name_bn' => 'তালতলী', 'lat' => 22.0697, 'lng' => 90.3900],
                ],
            ],
            [
                'name' => 'Barishal', 'name_bn' => 'বরিশাল', 'lat' => 22.7010, 'lng' => 90.3535,
                'upazilas' => [
                    ['name' => 'Agailjhara', 'name_bn' => 'আগৈলঝাড়া', 'lat' => 22.9694, 'lng' => 90.0195],
                    ['name' => 'Babuganj', 'name_bn' => 'বাবুগঞ্জ', 'lat' => 22.8236, 'lng' => 90.3386],
                    ['name' => 'Bakerganj', 'name_bn' => 'বাকেরগঞ্জ', 'lat' => 22.5651, 'lng' => 90.3373],
                    ['name' => 'Banaripara', 'name_bn' => 'বানারীপাড়া', 'lat' => 22.7930, 'lng' => 90.1653],
                    ['name' => 'Barishal Sadar', 'name_bn' => 'বরিশাল সদর', 'lat' => 22.7010, 'lng' => 90.3535],
                    ['name' => 'Gournadi', 'name_bn' => 'গৌরনদী', 'lat' => 22.9736, 'lng' => 90.2317],
                    ['name' => 'Hizla', 'name_bn' => 'হিজলা', 'lat' => 22.6337, 'lng' => 90.5093],
                    ['name' => 'Mehendiganj', 'name_bn' => 'মেহেন্দিগঞ্জ', 'lat' => 22.8300, 'lng' => 90.5500],
                    ['name' => 'Muladi', 'name_bn' => 'মুলাদী', 'lat' => 22.8522, 'lng' => 90.4627],
                    ['name' => 'Wazirpur', 'name_bn' => 'উজিরপুর', 'lat' => 22.8333, 'lng' => 90.2333],
                ],
            ],
            [
                'name' => 'Bhola', 'name_bn' => 'ভোলা', 'lat' => 22.6859, 'lng' => 90.6482,
                'upazilas' => [
                    ['name' => 'Bhola Sadar', 'name_bn' => 'ভোলা সদর', 'lat' => 22.6859, 'lng' => 90.6482],
                    ['name' => 'Burhanuddin', 'name_bn' => 'বোরহানউদ্দিন', 'lat' => 22.5030, 'lng' => 90.7270],
                    ['name' => 'Char Fasson', 'name_bn' => 'চরফ্যাশন', 'lat' => 22.2033, 'lng' => 90.7566],
                    ['name' => 'Daulatkhan', 'name_bn' => 'দৌলতখান', 'lat' => 22.6046, 'lng' => 90.7437],
                    ['name' => 'Lalmohan', 'name_bn' => 'লালমোহন', 'lat' => 22.3377, 'lng' => 90.7456],
                    ['name' => 'Manpura', 'name_bn' => 'মনপুরা', 'lat' => 22.4380, 'lng' => 90.6498],
                    ['name' => 'Tazumuddin', 'name_bn' => 'তজুমদ্দিন', 'lat' => 22.4403, 'lng' => 90.8028],
                ],
            ],
            [
                'name' => 'Jhalokati', 'name_bn' => 'ঝালকাঠি', 'lat' => 22.6406, 'lng' => 90.2000,
                'upazilas' => [
                    ['name' => 'Jhalokati Sadar', 'name_bn' => 'ঝালকাঠি সদর', 'lat' => 22.6406, 'lng' => 90.2000],
                    ['name' => 'Kathalia', 'name_bn' => 'কাঠালিয়া', 'lat' => 22.5204, 'lng' => 90.2313],
                    ['name' => 'Nalchity', 'name_bn' => 'নলছিটি', 'lat' => 22.6327, 'lng' => 90.1113],
                    ['name' => 'Rajapur', 'name_bn' => 'রাজাপুর', 'lat' => 22.7216, 'lng' => 90.1894],
                ],
            ],
            [
                'name' => 'Patuakhali', 'name_bn' => 'পটুয়াখালী', 'lat' => 22.3596, 'lng' => 90.3290,
                'upazilas' => [
                    ['name' => 'Bauphal', 'name_bn' => 'বাউফল', 'lat' => 22.3969, 'lng' => 90.5417],
                    ['name' => 'Dashmina', 'name_bn' => 'দশমিনা', 'lat' => 22.2451, 'lng' => 90.5764],
                    ['name' => 'Dumki', 'name_bn' => 'দুমকি', 'lat' => 22.4517, 'lng' => 90.3717],
                    ['name' => 'Galachipa', 'name_bn' => 'গলাচিপা', 'lat' => 22.1550, 'lng' => 90.4350],
                    ['name' => 'Kalapara', 'name_bn' => 'কলাপাড়া', 'lat' => 21.9872, 'lng' => 90.2428],
                    ['name' => 'Mirzaganj', 'name_bn' => 'মির্জাগঞ্জ', 'lat' => 22.3233, 'lng' => 90.2733],
                    ['name' => 'Patuakhali Sadar', 'name_bn' => 'পটুয়াখালী সদর', 'lat' => 22.3596, 'lng' => 90.3290],
                    ['name' => 'Rangabali', 'name_bn' => 'রাঙ্গাবালী', 'lat' => 21.9220, 'lng' => 90.5020],
                ],
            ],
            [
                'name' => 'Pirojpur', 'name_bn' => 'পিরোজপুর', 'lat' => 22.5841, 'lng' => 89.9720,
                'upazilas' => [
                    ['name' => 'Bhandaria', 'name_bn' => 'ভাণ্ডারিয়া', 'lat' => 22.4831, 'lng' => 89.9815],
                    ['name' => 'Kawkhali', 'name_bn' => 'কাউখালী', 'lat' => 22.6128, 'lng' => 89.9803],
                    ['name' => 'Mathbaria', 'name_bn' => 'মঠবাড়িয়া', 'lat' => 22.3637, 'lng' => 89.9447],
                    ['name' => 'Nazirpur', 'name_bn' => 'নাজিরপুর', 'lat' => 22.6400, 'lng' => 89.9103],
                    ['name' => 'Nesarabad', 'name_bn' => 'নেছারাবাদ', 'lat' => 22.6263, 'lng' => 90.0531],
                    ['name' => 'Pirojpur Sadar', 'name_bn' => 'পিরোজপুর সদর', 'lat' => 22.5841, 'lng' => 89.9720],
                    ['name' => 'Zianagar', 'name_bn' => 'জিয়ানগর', 'lat' => 22.5300, 'lng' => 89.8900],
                ],
            ],

            // --- Chattogram Division ---
            [
                'name' => 'Bandarban', 'name_bn' => 'বান্দরবান', 'lat' => 22.1953, 'lng' => 92.2184,
                'upazilas' => [
                    ['name' => 'Ali Kadam', 'name_bn' => 'আলীকদম', 'lat' => 21.6608, 'lng' => 92.3125],
                    ['name' => 'Bandarban Sadar', 'name_bn' => 'বান্দরবান সদর', 'lat' => 22.1953, 'lng' => 92.2184],
                    ['name' => 'Lama', 'name_bn' => 'লামা', 'lat' => 21.7833, 'lng' => 92.1833],
                    ['name' => 'Naikhongchhari', 'name_bn' => 'নাইক্ষ্যংছড়ি', 'lat' => 21.5014, 'lng' => 92.1833],
                    ['name' => 'Rowangchhari', 'name_bn' => 'রোয়াংছড়ি', 'lat' => 22.2833, 'lng' => 92.2833],
                    ['name' => 'Ruma', 'name_bn' => 'রুমা', 'lat' => 21.9833, 'lng' => 92.4000],
                    ['name' => 'Thanchi', 'name_bn' => 'থানচি', 'lat' => 21.6500, 'lng' => 92.4667],
                ],
            ],
            [
                'name' => 'Brahmanbaria', 'name_bn' => 'ব্রাহ্মণবাড়িয়া', 'lat' => 23.9608, 'lng' => 91.1115,
                'upazilas' => [
                    ['name' => 'Akhaura', 'name_bn' => 'আখাউড়া', 'lat' => 23.8833, 'lng' => 91.1833],
                    ['name' => 'Bancharampur', 'name_bn' => 'বাঞ্ছারামপুর', 'lat' => 23.9500, 'lng' => 90.9833],
                    ['name' => 'Brahmanbaria Sadar', 'name_bn' => 'ব্রাহ্মণবাড়িয়া সদর', 'lat' => 23.9608, 'lng' => 91.1115],
                    ['name' => 'Kasba', 'name_bn' => 'কসবা', 'lat' => 23.7833, 'lng' => 91.1500],
                    ['name' => 'Nabinagar', 'name_bn' => 'নবীনগর', 'lat' => 23.8833, 'lng' => 90.9500],
                    ['name' => 'Nasirnagar', 'name_bn' => 'নাসিরনগর', 'lat' => 24.0833, 'lng' => 91.0667],
                    ['name' => 'Sarail', 'name_bn' => 'সরাইল', 'lat' => 24.0833, 'lng' => 91.1500],
                    ['name' => 'Ashuganj', 'name_bn' => 'আশুগঞ্জ', 'lat' => 24.0333, 'lng' => 90.9833],
                    ['name' => 'Bijoynagar', 'name_bn' => 'বিজয়নগর', 'lat' => 23.8500, 'lng' => 91.0833],
                ],
            ],
            [
                'name' => 'Chandpur', 'name_bn' => 'চাঁদপুর', 'lat' => 23.2333, 'lng' => 90.6712,
                'upazilas' => [
                    ['name' => 'Chandpur Sadar', 'name_bn' => 'চাঁদপুর সদর', 'lat' => 23.2333, 'lng' => 90.6712],
                    ['name' => 'Faridganj', 'name_bn' => 'ফরিদগঞ্জ', 'lat' => 23.2167, 'lng' => 90.7667],
                    ['name' => 'Haimchar', 'name_bn' => 'হাইমচর', 'lat' => 23.3500, 'lng' => 90.6333],
                    ['name' => 'Haziganj', 'name_bn' => 'হাজীগঞ্জ', 'lat' => 23.3167, 'lng' => 90.8500],
                    ['name' => 'Kachua', 'name_bn' => 'কচুয়া', 'lat' => 23.3833, 'lng' => 90.7833],
                    ['name' => 'Matlab Dakshin', 'name_bn' => 'মতলব দক্ষিণ', 'lat' => 23.2500, 'lng' => 90.5833],
                    ['name' => 'Matlab Uttar', 'name_bn' => 'মতলব উত্তর', 'lat' => 23.3667, 'lng' => 90.5500],
                    ['name' => 'Shahrasti', 'name_bn' => 'শাহরাস্তি', 'lat' => 23.2000, 'lng' => 90.8833],
                ],
            ],
            [
                'name' => 'Chattogram', 'name_bn' => 'চট্টগ্রাম', 'lat' => 22.3569, 'lng' => 91.7832,
                'upazilas' => [
                    ['name' => 'Anwara', 'name_bn' => 'আনোয়ারা', 'lat' => 22.2333, 'lng' => 91.8833],
                    ['name' => 'Banshkhali', 'name_bn' => 'বাঁশখালী', 'lat' => 22.0667, 'lng' => 91.9833],
                    ['name' => 'Boalkhali', 'name_bn' => 'বোয়ালখালী', 'lat' => 22.3667, 'lng' => 91.9333],
                    ['name' => 'Chandanaish', 'name_bn' => 'চন্দনাইশ', 'lat' => 22.2333, 'lng' => 92.0167],
                    ['name' => 'Fatikchhari', 'name_bn' => 'ফটিকছড়ি', 'lat' => 22.6667, 'lng' => 91.7833],
                    ['name' => 'Hathazari', 'name_bn' => 'হাটহাজারী', 'lat' => 22.5167, 'lng' => 91.8000],
                    ['name' => 'Karnaphuli', 'name_bn' => 'কর্ণফুলী', 'lat' => 22.2833, 'lng' => 91.8333],
                    ['name' => 'Lohagara', 'name_bn' => 'লোহাগাড়া', 'lat' => 22.0667, 'lng' => 92.1000],
                    ['name' => 'Mirsharai', 'name_bn' => 'মীরসরাই', 'lat' => 22.7667, 'lng' => 91.5833],
                    ['name' => 'Patiya', 'name_bn' => 'পটিয়া', 'lat' => 22.2833, 'lng' => 91.9667],
                    ['name' => 'Rangunia', 'name_bn' => 'রাঙ্গুনিয়া', 'lat' => 22.4667, 'lng' => 92.0500],
                    ['name' => 'Raozan', 'name_bn' => 'রাউজান', 'lat' => 22.5333, 'lng' => 91.9333],
                    ['name' => 'Sandwip', 'name_bn' => 'সন্দ্বীপ', 'lat' => 22.4833, 'lng' => 91.4333],
                    ['name' => 'Satkania', 'name_bn' => 'সাতকানিয়া', 'lat' => 22.1000, 'lng' => 92.0667],
                    ['name' => 'Sitakunda', 'name_bn' => 'সীতাকুণ্ড', 'lat' => 22.6167, 'lng' => 91.6667],
                ],
            ],
            [
                'name' => 'Comilla', 'name_bn' => 'কুমিল্লা', 'lat' => 23.4607, 'lng' => 91.1809,
                'upazilas' => [
                    ['name' => 'Barura', 'name_bn' => 'বরুড়া', 'lat' => 23.3333, 'lng' => 91.0667],
                    ['name' => 'Brahmanpara', 'name_bn' => 'ব্রাহ্মণপাড়া', 'lat' => 23.6333, 'lng' => 91.1167],
                    ['name' => 'Burichang', 'name_bn' => 'বুড়িচং', 'lat' => 23.6000, 'lng' => 91.0833],
                    ['name' => 'Chandina', 'name_bn' => 'চান্দিনা', 'lat' => 23.5333, 'lng' => 91.0333],
                    ['name' => 'Chauddagram', 'name_bn' => 'চৌদ্দগ্রাম', 'lat' => 23.2833, 'lng' => 91.2500],
                    ['name' => 'Comilla Adarsha Sadar', 'name_bn' => 'কুমিল্লা আদর্শ সদর', 'lat' => 23.4607, 'lng' => 91.1809],
                    ['name' => 'Comilla Sadar Dakshin', 'name_bn' => 'কুমিল্লা সদর দক্ষিণ', 'lat' => 23.4167, 'lng' => 91.1667],
                    ['name' => 'Daudkandi', 'name_bn' => 'দাউদকান্দি', 'lat' => 23.5333, 'lng' => 90.7333],
                    ['name' => 'Debidwar', 'name_bn' => 'দেবিদ্বার', 'lat' => 23.6667, 'lng' => 91.0167],
                    ['name' => 'Homna', 'name_bn' => 'হোমনা', 'lat' => 23.6500, 'lng' => 90.7833],
                    ['name' => 'Laksam', 'name_bn' => 'লাকসাম', 'lat' => 23.2500, 'lng' => 91.1333],
                    ['name' => 'Lalmai', 'name_bn' => 'লালমাই', 'lat' => 23.3833, 'lng' => 91.1333],
                    ['name' => 'Meghna', 'name_bn' => 'মেঘনা', 'lat' => 23.4667, 'lng' => 90.7333],
                    ['name' => 'Monohorgonj', 'name_bn' => 'মনোহরগঞ্জ', 'lat' => 23.2500, 'lng' => 91.0000],
                    ['name' => 'Muradnagar', 'name_bn' => 'মুরাদনগর', 'lat' => 23.7500, 'lng' => 90.9333],
                    ['name' => 'Nangalkot', 'name_bn' => 'নাঙ্গলকোট', 'lat' => 23.2833, 'lng' => 91.1833],
                    ['name' => 'Titas', 'name_bn' => 'তিতাস', 'lat' => 23.6167, 'lng' => 90.8667],
                ],
            ],
            [
                'name' => "Cox's Bazar", 'name_bn' => 'কক্সবাজার', 'lat' => 21.4272, 'lng' => 92.0058,
                'upazilas' => [
                    ['name' => 'Chakaria', 'name_bn' => 'চকরিয়া', 'lat' => 21.6500, 'lng' => 92.0500],
                    ['name' => "Cox's Bazar Sadar", 'name_bn' => 'কক্সবাজার সদর', 'lat' => 21.4272, 'lng' => 92.0058],
                    ['name' => 'Kutubdia', 'name_bn' => 'কুতুবদিয়া', 'lat' => 21.8167, 'lng' => 91.8500],
                    ['name' => 'Maheshkhali', 'name_bn' => 'মহেশখালী', 'lat' => 21.5500, 'lng' => 91.8833],
                    ['name' => 'Pekua', 'name_bn' => 'পেকুয়া', 'lat' => 21.6833, 'lng' => 91.9667],
                    ['name' => 'Ramu', 'name_bn' => 'রামু', 'lat' => 21.4333, 'lng' => 92.1000],
                    ['name' => 'Teknaf', 'name_bn' => 'টেকনাফ', 'lat' => 20.8833, 'lng' => 92.2833],
                    ['name' => 'Ukhia', 'name_bn' => 'উখিয়া', 'lat' => 21.2500, 'lng' => 92.1167],
                ],
            ],
            [
                'name' => 'Feni', 'name_bn' => 'ফেনী', 'lat' => 23.0101, 'lng' => 91.3976,
                'upazilas' => [
                    ['name' => 'Chhagalnaiya', 'name_bn' => 'ছাগলনাইয়া', 'lat' => 23.0667, 'lng' => 91.5167],
                    ['name' => 'Daganbhuiyan', 'name_bn' => 'দাগনভূঁইয়া', 'lat' => 22.9833, 'lng' => 91.5000],
                    ['name' => 'Feni Sadar', 'name_bn' => 'ফেনী সদর', 'lat' => 23.0101, 'lng' => 91.3976],
                    ['name' => 'Fulgazi', 'name_bn' => 'ফুলগাজী', 'lat' => 23.1167, 'lng' => 91.4167],
                    ['name' => 'Parshuram', 'name_bn' => 'পরশুরাম', 'lat' => 23.1500, 'lng' => 91.4500],
                    ['name' => 'Sonagazi', 'name_bn' => 'সোনাগাজী', 'lat' => 22.8500, 'lng' => 91.4000],
                ],
            ],
            [
                'name' => 'Khagrachhari', 'name_bn' => 'খাগড়াছড়ি', 'lat' => 23.1193, 'lng' => 91.9847,
                'upazilas' => [
                    ['name' => 'Dighinala', 'name_bn' => 'দীঘিনালা', 'lat' => 23.2500, 'lng' => 92.0333],
                    ['name' => 'Khagrachhari Sadar', 'name_bn' => 'খাগড়াছড়ি সদর', 'lat' => 23.1193, 'lng' => 91.9847],
                    ['name' => 'Lakshmichhari', 'name_bn' => 'লক্ষ্মীছড়ি', 'lat' => 22.9000, 'lng' => 91.9500],
                    ['name' => 'Mahalchhari', 'name_bn' => 'মহালছড়ি', 'lat' => 23.1167, 'lng' => 92.1000],
                    ['name' => 'Manikchhari', 'name_bn' => 'মানিকছড়ি', 'lat' => 22.9667, 'lng' => 91.8500],
                    ['name' => 'Matiranga', 'name_bn' => 'মাটিরাঙ্গা', 'lat' => 23.0333, 'lng' => 91.8833],
                    ['name' => 'Panchhari', 'name_bn' => 'পানছড়ি', 'lat' => 23.2833, 'lng' => 92.1000],
                    ['name' => 'Ramgarh', 'name_bn' => 'রামগড়', 'lat' => 23.0833, 'lng' => 91.8333],
                    ['name' => 'Guimara', 'name_bn' => 'গুইমারা', 'lat' => 23.1500, 'lng' => 91.8833],
                ],
            ],
            [
                'name' => 'Lakshmipur', 'name_bn' => 'লক্ষ্মীপুর', 'lat' => 22.9425, 'lng' => 90.8281,
                'upazilas' => [
                    ['name' => 'Kamalnagar', 'name_bn' => 'কমলনগর', 'lat' => 22.6667, 'lng' => 90.8500],
                    ['name' => 'Lakshmipur Sadar', 'name_bn' => 'লক্ষ্মীপুর সদর', 'lat' => 22.9425, 'lng' => 90.8281],
                    ['name' => 'Raipur', 'name_bn' => 'রায়পুর', 'lat' => 22.9833, 'lng' => 90.7333],
                    ['name' => 'Ramganj', 'name_bn' => 'রামগঞ্জ', 'lat' => 23.0833, 'lng' => 90.8833],
                    ['name' => 'Ramgati', 'name_bn' => 'রামগতি', 'lat' => 22.7500, 'lng' => 90.7667],
                ],
            ],
            [
                'name' => 'Noakhali', 'name_bn' => 'নোয়াখালী', 'lat' => 22.8696, 'lng' => 91.0995,
                'upazilas' => [
                    ['name' => 'Begumganj', 'name_bn' => 'বেগমগঞ্জ', 'lat' => 22.8167, 'lng' => 91.1000],
                    ['name' => 'Chatkhil', 'name_bn' => 'চাটখিল', 'lat' => 22.9500, 'lng' => 91.1500],
                    ['name' => 'Companiganj', 'name_bn' => 'কোম্পানীগঞ্জ', 'lat' => 22.7333, 'lng' => 91.2333],
                    ['name' => 'Hatiya', 'name_bn' => 'হাতিয়া', 'lat' => 22.4000, 'lng' => 91.0833],
                    ['name' => 'Kabirhat', 'name_bn' => 'কবিরহাট', 'lat' => 22.8333, 'lng' => 91.1833],
                    ['name' => 'Noakhali Sadar', 'name_bn' => 'নোয়াখালী সদর', 'lat' => 22.8696, 'lng' => 91.0995],
                    ['name' => 'Senbagh', 'name_bn' => 'সেনবাগ', 'lat' => 22.9833, 'lng' => 91.1667],
                    ['name' => 'Sonaimuri', 'name_bn' => 'সোনাইমুড়ী', 'lat' => 23.0167, 'lng' => 91.0500],
                    ['name' => 'Subarnachar', 'name_bn' => 'সুবর্ণচর', 'lat' => 22.6667, 'lng' => 91.0167],
                ],
            ],
            [
                'name' => 'Rangamati', 'name_bn' => 'রাঙ্গামাটি', 'lat' => 22.7324, 'lng' => 92.2985,
                'upazilas' => [
                    ['name' => 'Bagaichhari', 'name_bn' => 'বাঘাইছড়ি', 'lat' => 23.2667, 'lng' => 92.2000],
                    ['name' => 'Barkal', 'name_bn' => 'বরকল', 'lat' => 23.0000, 'lng' => 92.3500],
                    ['name' => 'Belaichhari', 'name_bn' => 'বিলাইছড়ি', 'lat' => 22.6333, 'lng' => 92.4000],
                    ['name' => 'Juraichhari', 'name_bn' => 'জুরাছড়ি', 'lat' => 22.6000, 'lng' => 92.2333],
                    ['name' => 'Kaptai', 'name_bn' => 'কাপ্তাই', 'lat' => 22.5000, 'lng' => 92.2333],
                    ['name' => 'Kawkhali', 'name_bn' => 'কাউখালী', 'lat' => 22.5333, 'lng' => 92.0667],
                    ['name' => 'Langadu', 'name_bn' => 'লংগদু', 'lat' => 23.1333, 'lng' => 92.1667],
                    ['name' => 'Naniarchar', 'name_bn' => 'নানিয়ারচর', 'lat' => 22.6833, 'lng' => 92.1500],
                    ['name' => 'Rajasthali', 'name_bn' => 'রাজস্থলী', 'lat' => 22.4333, 'lng' => 92.1667],
                    ['name' => 'Rangamati Sadar', 'name_bn' => 'রাঙ্গামাটি সদর', 'lat' => 22.7324, 'lng' => 92.2985],
                ],
            ],

            // --- Dhaka Division ---
            [
                'name' => 'Dhaka', 'name_bn' => 'ঢাকা', 'lat' => 23.8103, 'lng' => 90.4125,
                'upazilas' => [
                    ['name' => 'Dhamrai', 'name_bn' => 'ধামরাই', 'lat' => 23.9167, 'lng' => 90.1667],
                    ['name' => 'Dohar', 'name_bn' => 'দোহার', 'lat' => 23.6000, 'lng' => 90.1333],
                    ['name' => 'Keraniganj', 'name_bn' => 'কেরানীগঞ্জ', 'lat' => 23.6833, 'lng' => 90.3500],
                    ['name' => 'Nawabganj', 'name_bn' => 'নবাবগঞ্জ', 'lat' => 23.7333, 'lng' => 90.2167],
                    ['name' => 'Savar', 'name_bn' => 'সাভার', 'lat' => 23.8583, 'lng' => 90.2667],
                ],
            ],
            [
                'name' => 'Faridpur', 'name_bn' => 'ফরিদপুর', 'lat' => 23.6070, 'lng' => 89.8420,
                'upazilas' => [
                    ['name' => 'Alfadanga', 'name_bn' => 'আলফাডাঙ্গা', 'lat' => 23.5167, 'lng' => 89.7167],
                    ['name' => 'Bhanga', 'name_bn' => 'ভাঙ্গা', 'lat' => 23.4333, 'lng' => 89.9833],
                    ['name' => 'Boalmari', 'name_bn' => 'বোয়ালমারী', 'lat' => 23.3667, 'lng' => 89.7000],
                    ['name' => 'Charbhadrasan', 'name_bn' => 'চরভদ্রাসন', 'lat' => 23.7167, 'lng' => 89.8167],
                    ['name' => 'Faridpur Sadar', 'name_bn' => 'ফরিদপুর সদর', 'lat' => 23.6070, 'lng' => 89.8420],
                    ['name' => 'Madhukhali', 'name_bn' => 'মধুখালী', 'lat' => 23.5000, 'lng' => 89.6833],
                    ['name' => 'Nagarkanda', 'name_bn' => 'নগরকান্দা', 'lat' => 23.4833, 'lng' => 89.8500],
                    ['name' => 'Sadarpur', 'name_bn' => 'সদরপুর', 'lat' => 23.4833, 'lng' => 90.0500],
                    ['name' => 'Saltha', 'name_bn' => 'সালথা', 'lat' => 23.3167, 'lng' => 89.7833],
                ],
            ],
            [
                'name' => 'Gazipur', 'name_bn' => 'গাজীপুর', 'lat' => 24.0023, 'lng' => 90.4193,
                'upazilas' => [
                    ['name' => 'Gazipur Sadar', 'name_bn' => 'গাজীপুর সদর', 'lat' => 24.0023, 'lng' => 90.4193],
                    ['name' => 'Kaliakair', 'name_bn' => 'কালিয়াকৈর', 'lat' => 24.0667, 'lng' => 90.2333],
                    ['name' => 'Kaliganj', 'name_bn' => 'কালীগঞ্জ', 'lat' => 24.0833, 'lng' => 90.5833],
                    ['name' => 'Kapasia', 'name_bn' => 'কাপাসিয়া', 'lat' => 24.1167, 'lng' => 90.6500],
                    ['name' => 'Sreepur', 'name_bn' => 'শ্রীপুর', 'lat' => 24.2000, 'lng' => 90.4833],
                ],
            ],
            [
                'name' => 'Gopalganj', 'name_bn' => 'গোপালগঞ্জ', 'lat' => 23.0050, 'lng' => 89.8266,
                'upazilas' => [
                    ['name' => 'Gopalganj Sadar', 'name_bn' => 'গোপালগঞ্জ সদর', 'lat' => 23.0050, 'lng' => 89.8266],
                    ['name' => 'Kashiani', 'name_bn' => 'কাশিয়ানী', 'lat' => 23.0333, 'lng' => 89.7000],
                    ['name' => 'Kotalipara', 'name_bn' => 'কোটালীপাড়া', 'lat' => 23.0500, 'lng' => 89.9500],
                    ['name' => 'Muksudpur', 'name_bn' => 'মুকসুদপুর', 'lat' => 23.1500, 'lng' => 89.8833],
                    ['name' => 'Tungipara', 'name_bn' => 'টুঙ্গিপাড়া', 'lat' => 22.9500, 'lng' => 89.9000],
                ],
            ],
            [
                'name' => 'Kishoreganj', 'name_bn' => 'কিশোরগঞ্জ', 'lat' => 24.4449, 'lng' => 90.7766,
                'upazilas' => [
                    ['name' => 'Austagram', 'name_bn' => 'অষ্টগ্রাম', 'lat' => 24.5500, 'lng' => 91.0667],
                    ['name' => 'Bajitpur', 'name_bn' => 'বাজিতপুর', 'lat' => 24.2167, 'lng' => 90.9500],
                    ['name' => 'Bhairab', 'name_bn' => 'ভৈরব', 'lat' => 24.0500, 'lng' => 90.9833],
                    ['name' => 'Hossainpur', 'name_bn' => 'হোসেনপুর', 'lat' => 24.4333, 'lng' => 90.6667],
                    ['name' => 'Itna', 'name_bn' => 'ইটনা', 'lat' => 24.6500, 'lng' => 91.1000],
                    ['name' => 'Karimganj', 'name_bn' => 'করিমগঞ্জ', 'lat' => 24.3667, 'lng' => 90.6500],
                    ['name' => 'Katiadi', 'name_bn' => 'কটিয়াদি', 'lat' => 24.3000, 'lng' => 90.8333],
                    ['name' => 'Kishoreganj Sadar', 'name_bn' => 'কিশোরগঞ্জ সদর', 'lat' => 24.4449, 'lng' => 90.7766],
                    ['name' => 'Kuliarchar', 'name_bn' => 'কুলিয়ারচর', 'lat' => 24.2500, 'lng' => 90.8833],
                    ['name' => 'Mithamain', 'name_bn' => 'মিঠামইন', 'lat' => 24.6167, 'lng' => 91.0333],
                    ['name' => 'Nikli', 'name_bn' => 'নিকলী', 'lat' => 24.5667, 'lng' => 90.9333],
                    ['name' => 'Pakundia', 'name_bn' => 'পাকুন্দিয়া', 'lat' => 24.3667, 'lng' => 90.7167],
                    ['name' => 'Tarail', 'name_bn' => 'তাড়াইল', 'lat' => 24.5500, 'lng' => 90.8500],
                ],
            ],
            [
                'name' => 'Madaripur', 'name_bn' => 'মাদারীপুর', 'lat' => 23.1641, 'lng' => 90.1978,
                'upazilas' => [
                    ['name' => 'Kalkini', 'name_bn' => 'কালকিনি', 'lat' => 23.0500, 'lng' => 90.2333],
                    ['name' => 'Madaripur Sadar', 'name_bn' => 'মাদারীপুর সদর', 'lat' => 23.1641, 'lng' => 90.1978],
                    ['name' => 'Rajoir', 'name_bn' => 'রাজৈর', 'lat' => 23.2333, 'lng' => 90.1000],
                    ['name' => 'Shibchar', 'name_bn' => 'শিবচর', 'lat' => 23.3500, 'lng' => 90.1667],
                ],
            ],
            [
                'name' => 'Manikganj', 'name_bn' => 'মানিকগঞ্জ', 'lat' => 23.8644, 'lng' => 90.0047,
                'upazilas' => [
                    ['name' => 'Daulatpur', 'name_bn' => 'দৌলতপুর', 'lat' => 23.9333, 'lng' => 89.8667],
                    ['name' => 'Ghior', 'name_bn' => 'ঘিওর', 'lat' => 23.8833, 'lng' => 89.9000],
                    ['name' => 'Harirampur', 'name_bn' => 'হরিরামপুর', 'lat' => 23.7333, 'lng' => 89.9667],
                    ['name' => 'Manikganj Sadar', 'name_bn' => 'মানিকগঞ্জ সদর', 'lat' => 23.8644, 'lng' => 90.0047],
                    ['name' => 'Saturia', 'name_bn' => 'সাটুরিয়া', 'lat' => 23.8167, 'lng' => 90.0500],
                    ['name' => 'Shibalaya', 'name_bn' => 'শিবালয়', 'lat' => 23.8500, 'lng' => 89.8167],
                    ['name' => 'Singair', 'name_bn' => 'সিংগাইর', 'lat' => 23.7833, 'lng' => 90.1500],
                ],
            ],
            [
                'name' => 'Munshiganj', 'name_bn' => 'মুন্সিগঞ্জ', 'lat' => 23.5422, 'lng' => 90.5305,
                'upazilas' => [
                    ['name' => 'Gazaria', 'name_bn' => 'গজারিয়া', 'lat' => 23.5667, 'lng' => 90.6167],
                    ['name' => 'Lohajang', 'name_bn' => 'লৌহজং', 'lat' => 23.4333, 'lng' => 90.3667],
                    ['name' => 'Munshiganj Sadar', 'name_bn' => 'মুন্সিগঞ্জ সদর', 'lat' => 23.5422, 'lng' => 90.5305],
                    ['name' => 'Sirajdikhan', 'name_bn' => 'সিরাজদিখান', 'lat' => 23.4167, 'lng' => 90.3500],
                    ['name' => 'Sreenagar', 'name_bn' => 'শ্রীনগর', 'lat' => 23.5167, 'lng' => 90.3167],
                    ['name' => 'Tongibari', 'name_bn' => 'টঙ্গীবাড়ী', 'lat' => 23.5000, 'lng' => 90.4000],
                ],
            ],
            [
                'name' => 'Narayanganj', 'name_bn' => 'নারায়ণগঞ্জ', 'lat' => 23.6238, 'lng' => 90.5000,
                'upazilas' => [
                    ['name' => 'Araihazar', 'name_bn' => 'আড়াইহাজার', 'lat' => 23.7333, 'lng' => 90.6500],
                    ['name' => 'Bandar', 'name_bn' => 'বন্দর', 'lat' => 23.6000, 'lng' => 90.5500],
                    ['name' => 'Narayanganj Sadar', 'name_bn' => 'নারায়ণগঞ্জ সদর', 'lat' => 23.6238, 'lng' => 90.5000],
                    ['name' => 'Rupganj', 'name_bn' => 'রূপগঞ্জ', 'lat' => 23.7833, 'lng' => 90.5333],
                    ['name' => 'Sonargaon', 'name_bn' => 'সোনারগাঁও', 'lat' => 23.7000, 'lng' => 90.6333],
                ],
            ],
            [
                'name' => 'Narsingdi', 'name_bn' => 'নরসিংদী', 'lat' => 23.9322, 'lng' => 90.7151,
                'upazilas' => [
                    ['name' => 'Belabo', 'name_bn' => 'বেলাবো', 'lat' => 24.0833, 'lng' => 90.8333],
                    ['name' => 'Monohardi', 'name_bn' => 'মনোহরদী', 'lat' => 24.1000, 'lng' => 90.7000],
                    ['name' => 'Narsingdi Sadar', 'name_bn' => 'নরসিংদী সদর', 'lat' => 23.9322, 'lng' => 90.7151],
                    ['name' => 'Palash', 'name_bn' => 'পলাশ', 'lat' => 23.9667, 'lng' => 90.6500],
                    ['name' => 'Raipura', 'name_bn' => 'রায়পুরা', 'lat' => 24.0500, 'lng' => 90.7833],
                    ['name' => 'Shibpur', 'name_bn' => 'শিবপুর', 'lat' => 23.8500, 'lng' => 90.7500],
                ],
            ],
            [
                'name' => 'Rajbari', 'name_bn' => 'রাজবাড়ী', 'lat' => 23.7574, 'lng' => 89.6445,
                'upazilas' => [
                    ['name' => 'Baliakandi', 'name_bn' => 'বালিয়াকান্দি', 'lat' => 23.6333, 'lng' => 89.6667],
                    ['name' => 'Goalandaghat', 'name_bn' => 'গোয়ালন্দঘাট', 'lat' => 23.7667, 'lng' => 89.7833],
                    ['name' => 'Kalukhali', 'name_bn' => 'কালুখালী', 'lat' => 23.6833, 'lng' => 89.5833],
                    ['name' => 'Pangsha', 'name_bn' => 'পাংশা', 'lat' => 23.7167, 'lng' => 89.5167],
                    ['name' => 'Rajbari Sadar', 'name_bn' => 'রাজবাড়ী সদর', 'lat' => 23.7574, 'lng' => 89.6445],
                ],
            ],
            [
                'name' => 'Shariatpur', 'name_bn' => 'শরীয়তপুর', 'lat' => 23.2423, 'lng' => 90.4348,
                'upazilas' => [
                    ['name' => 'Bhedarganj', 'name_bn' => 'ভেদরগঞ্জ', 'lat' => 23.2500, 'lng' => 90.4667],
                    ['name' => 'Damudya', 'name_bn' => 'ডামুড্যা', 'lat' => 23.2667, 'lng' => 90.3667],
                    ['name' => 'Gosairhat', 'name_bn' => 'গোসাইরহাট', 'lat' => 23.1333, 'lng' => 90.3500],
                    ['name' => 'Naria', 'name_bn' => 'নড়িয়া', 'lat' => 23.3167, 'lng' => 90.3167],
                    ['name' => 'Shariatpur Sadar', 'name_bn' => 'শরীয়তপুর সদর', 'lat' => 23.2423, 'lng' => 90.4348],
                    ['name' => 'Zajira', 'name_bn' => 'জাজিরা', 'lat' => 23.3167, 'lng' => 90.4833],
                ],
            ],
            [
                'name' => 'Tangail', 'name_bn' => 'টাঙ্গাইল', 'lat' => 24.2513, 'lng' => 89.9163,
                'upazilas' => [
                    ['name' => 'Basail', 'name_bn' => 'বাসাইল', 'lat' => 24.2167, 'lng' => 90.0500],
                    ['name' => 'Bhuapur', 'name_bn' => 'ভুয়াপুর', 'lat' => 24.5000, 'lng' => 89.9333],
                    ['name' => 'Delduar', 'name_bn' => 'দেলদুয়ার', 'lat' => 24.2333, 'lng' => 89.9667],
                    ['name' => 'Dhanbari', 'name_bn' => 'ধনবাড়ী', 'lat' => 24.6333, 'lng' => 90.0167],
                    ['name' => 'Ghatail', 'name_bn' => 'ঘাটাইল', 'lat' => 24.4833, 'lng' => 90.0167],
                    ['name' => 'Gopalpur', 'name_bn' => 'গোপালপুর', 'lat' => 24.5500, 'lng' => 89.9167],
                    ['name' => 'Kalihati', 'name_bn' => 'কালিহাতী', 'lat' => 24.3667, 'lng' => 89.9333],
                    ['name' => 'Madhupur', 'name_bn' => 'মধুপুর', 'lat' => 24.7167, 'lng' => 90.0167],
                    ['name' => 'Mirzapur', 'name_bn' => 'মির্জাপুর', 'lat' => 24.1167, 'lng' => 90.0833],
                    ['name' => 'Nagarpur', 'name_bn' => 'নাগরপুর', 'lat' => 24.0667, 'lng' => 89.8667],
                    ['name' => 'Sakhipur', 'name_bn' => 'সখিপুর', 'lat' => 24.3000, 'lng' => 90.1667],
                    ['name' => 'Tangail Sadar', 'name_bn' => 'টাঙ্গাইল সদর', 'lat' => 24.2513, 'lng' => 89.9163],
                ],
            ],

            // --- Khulna Division ---
            [
                'name' => 'Bagerhat', 'name_bn' => 'বাগেরহাট', 'lat' => 22.6512, 'lng' => 89.7851,
                'upazilas' => [
                    ['name' => 'Bagerhat Sadar', 'name_bn' => 'বাগেরহাট সদর', 'lat' => 22.6512, 'lng' => 89.7851],
                    ['name' => 'Chitalmari', 'name_bn' => 'চিতলমারী', 'lat' => 22.7167, 'lng' => 89.7000],
                    ['name' => 'Fakirhat', 'name_bn' => 'ফকিরহাট', 'lat' => 22.6667, 'lng' => 89.6833],
                    ['name' => 'Kachua', 'name_bn' => 'কচুয়া', 'lat' => 22.7667, 'lng' => 89.8167],
                    ['name' => 'Mollahat', 'name_bn' => 'মোল্লাহাট', 'lat' => 22.8000, 'lng' => 89.7667],
                    ['name' => 'Mongla', 'name_bn' => 'মোংলা', 'lat' => 22.4833, 'lng' => 89.6167],
                    ['name' => 'Morrelganj', 'name_bn' => 'মোড়েলগঞ্জ', 'lat' => 22.4500, 'lng' => 89.8500],
                    ['name' => 'Rampal', 'name_bn' => 'রামপাল', 'lat' => 22.5333, 'lng' => 89.7167],
                    ['name' => 'Sarankhola', 'name_bn' => 'শরণখোলা', 'lat' => 22.3000, 'lng' => 89.7833],
                ],
            ],
            [
                'name' => 'Chuadanga', 'name_bn' => 'চুয়াডাঙ্গা', 'lat' => 23.6401, 'lng' => 88.8418,
                'upazilas' => [
                    ['name' => 'Alamdanga', 'name_bn' => 'আলমডাঙ্গা', 'lat' => 23.7667, 'lng' => 88.9333],
                    ['name' => 'Chuadanga Sadar', 'name_bn' => 'চুয়াডাঙ্গা সদর', 'lat' => 23.6401, 'lng' => 88.8418],
                    ['name' => 'Damurhuda', 'name_bn' => 'দামুড়হুদা', 'lat' => 23.6167, 'lng' => 88.7500],
                    ['name' => 'Jibannagar', 'name_bn' => 'জীবননগর', 'lat' => 23.5500, 'lng' => 88.8500],
                ],
            ],
            [
                'name' => 'Jessore', 'name_bn' => 'যশোর', 'lat' => 23.1667, 'lng' => 89.2167,
                'upazilas' => [
                    ['name' => 'Abhaynagar', 'name_bn' => 'অভয়নগর', 'lat' => 23.0167, 'lng' => 89.4333],
                    ['name' => 'Bagherpara', 'name_bn' => 'বাঘারপাড়া', 'lat' => 23.2000, 'lng' => 89.1500],
                    ['name' => 'Chaugachha', 'name_bn' => 'চৌগাছা', 'lat' => 23.1333, 'lng' => 89.0833],
                    ['name' => 'Jessore Sadar', 'name_bn' => 'যশোর সদর', 'lat' => 23.1667, 'lng' => 89.2167],
                    ['name' => 'Jhikargachha', 'name_bn' => 'ঝিকরগাছা', 'lat' => 22.8167, 'lng' => 89.1167],
                    ['name' => 'Keshabpur', 'name_bn' => 'কেশবপুর', 'lat' => 22.9000, 'lng' => 89.2167],
                    ['name' => 'Manirampur', 'name_bn' => 'মণিরামপুর', 'lat' => 22.9500, 'lng' => 89.3667],
                    ['name' => 'Sharsha', 'name_bn' => 'শার্শা', 'lat' => 23.0833, 'lng' => 88.9833],
                ],
            ],
            [
                'name' => 'Jhenaidah', 'name_bn' => 'ঝিনাইদহ', 'lat' => 23.5450, 'lng' => 89.1726,
                'upazilas' => [
                    ['name' => 'Harinakunda', 'name_bn' => 'হরিণাকুণ্ডু', 'lat' => 23.5667, 'lng' => 89.1333],
                    ['name' => 'Jhenaidah Sadar', 'name_bn' => 'ঝিনাইদহ সদর', 'lat' => 23.5450, 'lng' => 89.1726],
                    ['name' => 'Kaliganj', 'name_bn' => 'কালীগঞ্জ', 'lat' => 23.4167, 'lng' => 89.1500],
                    ['name' => 'Kotchandpur', 'name_bn' => 'কোটচাঁদপুর', 'lat' => 23.4500, 'lng' => 89.0000],
                    ['name' => 'Maheshpur', 'name_bn' => 'মহেশপুর', 'lat' => 23.3667, 'lng' => 88.9167],
                    ['name' => 'Shailkupa', 'name_bn' => 'শৈলকুপা', 'lat' => 23.6500, 'lng' => 89.2500],
                ],
            ],
            [
                'name' => 'Khulna', 'name_bn' => 'খুলনা', 'lat' => 22.8456, 'lng' => 89.5403,
                'upazilas' => [
                    ['name' => 'Batiaghata', 'name_bn' => 'বটিয়াঘাটা', 'lat' => 22.7333, 'lng' => 89.5333],
                    ['name' => 'Dacope', 'name_bn' => 'দাকোপ', 'lat' => 22.5167, 'lng' => 89.5167],
                    ['name' => 'Dighalia', 'name_bn' => 'দিঘলিয়া', 'lat' => 22.9167, 'lng' => 89.4333],
                    ['name' => 'Dumuria', 'name_bn' => 'ডুমুরিয়া', 'lat' => 22.8000, 'lng' => 89.3667],
                    ['name' => 'Koyra', 'name_bn' => 'কয়রা', 'lat' => 22.3500, 'lng' => 89.3333],
                    ['name' => 'Paikgachha', 'name_bn' => 'পাইকগাছা', 'lat' => 22.6000, 'lng' => 89.3500],
                    ['name' => 'Phultala', 'name_bn' => 'ফুলতলা', 'lat' => 22.9500, 'lng' => 89.5333],
                    ['name' => 'Rupsa', 'name_bn' => 'রূপসা', 'lat' => 22.8333, 'lng' => 89.5833],
                    ['name' => 'Terokhada', 'name_bn' => 'তেরখাদা', 'lat' => 22.9500, 'lng' => 89.6500],
                ],
            ],
            [
                'name' => 'Kushtia', 'name_bn' => 'কুষ্টিয়া', 'lat' => 23.9013, 'lng' => 89.1200,
                'upazilas' => [
                    ['name' => 'Bheramara', 'name_bn' => 'ভেড়ামারা', 'lat' => 24.0333, 'lng' => 88.9833],
                    ['name' => 'Daulatpur', 'name_bn' => 'দৌলতপুর', 'lat' => 23.9833, 'lng' => 89.0167],
                    ['name' => 'Khoksa', 'name_bn' => 'খোকসা', 'lat' => 23.7833, 'lng' => 89.1667],
                    ['name' => 'Kumarkhali', 'name_bn' => 'কুমারখালী', 'lat' => 23.8000, 'lng' => 89.2167],
                    ['name' => 'Kushtia Sadar', 'name_bn' => 'কুষ্টিয়া সদর', 'lat' => 23.9013, 'lng' => 89.1200],
                    ['name' => 'Mirpur', 'name_bn' => 'মিরপুর', 'lat' => 23.9167, 'lng' => 89.0167],
                ],
            ],
            [
                'name' => 'Magura', 'name_bn' => 'মাগুরা', 'lat' => 23.4873, 'lng' => 89.4197,
                'upazilas' => [
                    ['name' => 'Magura Sadar', 'name_bn' => 'মাগুরা সদর', 'lat' => 23.4873, 'lng' => 89.4197],
                    ['name' => 'Mohammadpur', 'name_bn' => 'মহম্মদপুর', 'lat' => 23.4500, 'lng' => 89.5167],
                    ['name' => 'Shalikha', 'name_bn' => 'শালিখা', 'lat' => 23.5667, 'lng' => 89.3500],
                    ['name' => 'Sreepur', 'name_bn' => 'শ্রীপুর', 'lat' => 23.5333, 'lng' => 89.5167],
                ],
            ],
            [
                'name' => 'Meherpur', 'name_bn' => 'মেহেরপুর', 'lat' => 23.7622, 'lng' => 88.6318,
                'upazilas' => [
                    ['name' => 'Gangni', 'name_bn' => 'গাংনী', 'lat' => 23.8167, 'lng' => 88.7500],
                    ['name' => 'Meherpur Sadar', 'name_bn' => 'মেহেরপুর সদর', 'lat' => 23.7622, 'lng' => 88.6318],
                    ['name' => 'Mujibnagar', 'name_bn' => 'মুজিবনগর', 'lat' => 23.6833, 'lng' => 88.6833],
                ],
            ],
            [
                'name' => 'Narail', 'name_bn' => 'নড়াইল', 'lat' => 23.1725, 'lng' => 89.5120,
                'upazilas' => [
                    ['name' => 'Kalia', 'name_bn' => 'কালিয়া', 'lat' => 23.0167, 'lng' => 89.6333],
                    ['name' => 'Lohagara', 'name_bn' => 'লোহাগড়া', 'lat' => 23.0833, 'lng' => 89.5333],
                    ['name' => 'Narail Sadar', 'name_bn' => 'নড়াইল সদর', 'lat' => 23.1725, 'lng' => 89.5120],
                ],
            ],
            [
                'name' => 'Satkhira', 'name_bn' => 'সাতক্ষীরা', 'lat' => 22.7185, 'lng' => 89.0705,
                'upazilas' => [
                    ['name' => 'Assasuni', 'name_bn' => 'আশাশুনি', 'lat' => 22.5333, 'lng' => 89.1833],
                    ['name' => 'Debhata', 'name_bn' => 'দেবহাটা', 'lat' => 22.5500, 'lng' => 89.0167],
                    ['name' => 'Kalaroa', 'name_bn' => 'কলারোয়া', 'lat' => 22.8833, 'lng' => 89.0333],
                    ['name' => 'Kaliganj', 'name_bn' => 'কালীগঞ্জ', 'lat' => 22.4500, 'lng' => 89.0500],
                    ['name' => 'Satkhira Sadar', 'name_bn' => 'সাতক্ষীরা সদর', 'lat' => 22.7185, 'lng' => 89.0705],
                    ['name' => 'Shyamnagar', 'name_bn' => 'শ্যামনগর', 'lat' => 22.3333, 'lng' => 89.1000],
                    ['name' => 'Tala', 'name_bn' => 'তালা', 'lat' => 22.6333, 'lng' => 89.2333],
                ],
            ],

            // --- Mymensingh Division ---
            [
                'name' => 'Jamalpur', 'name_bn' => 'জামালপুর', 'lat' => 24.9375, 'lng' => 89.9372,
                'upazilas' => [
                    ['name' => 'Bakshiganj', 'name_bn' => 'বকশীগঞ্জ', 'lat' => 25.1667, 'lng' => 89.8667],
                    ['name' => 'Dewanganj', 'name_bn' => 'দেওয়ানগঞ্জ', 'lat' => 25.0833, 'lng' => 89.8167],
                    ['name' => 'Islampur', 'name_bn' => 'ইসলামপুর', 'lat' => 25.1333, 'lng' => 89.7167],
                    ['name' => 'Jamalpur Sadar', 'name_bn' => 'জামালপুর সদর', 'lat' => 24.9375, 'lng' => 89.9372],
                    ['name' => 'Madarganj', 'name_bn' => 'মাদারগঞ্জ', 'lat' => 25.0833, 'lng' => 89.9500],
                    ['name' => 'Melandaha', 'name_bn' => 'মেলান্দহ', 'lat' => 24.8333, 'lng' => 89.8833],
                    ['name' => 'Sarishabari', 'name_bn' => 'সরিষাবাড়ী', 'lat' => 24.7500, 'lng' => 89.8333],
                ],
            ],
            [
                'name' => 'Mymensingh', 'name_bn' => 'ময়মনসিংহ', 'lat' => 24.7471, 'lng' => 90.4203,
                'upazilas' => [
                    ['name' => 'Bhaluka', 'name_bn' => 'ভালুকা', 'lat' => 24.3667, 'lng' => 90.3833],
                    ['name' => 'Dhobaura', 'name_bn' => 'ধোবাউড়া', 'lat' => 25.0833, 'lng' => 90.0667],
                    ['name' => 'Fulbaria', 'name_bn' => 'ফুলবাড়ীয়া', 'lat' => 24.5833, 'lng' => 90.2500],
                    ['name' => 'Gaffargaon', 'name_bn' => 'গফরগাঁও', 'lat' => 24.5167, 'lng' => 90.5333],
                    ['name' => 'Gauripur', 'name_bn' => 'গৌরীপুর', 'lat' => 25.0000, 'lng' => 90.2167],
                    ['name' => 'Haluaghat', 'name_bn' => 'হালুয়াঘাট', 'lat' => 25.0667, 'lng' => 90.2000],
                    ['name' => 'Ishwarganj', 'name_bn' => 'ঈশ্বরগঞ্জ', 'lat' => 24.6333, 'lng' => 90.6000],
                    ['name' => 'Muktagachha', 'name_bn' => 'মুক্তাগাছা', 'lat' => 24.7667, 'lng' => 90.2667],
                    ['name' => 'Mymensingh Sadar', 'name_bn' => 'ময়মনসিংহ সদর', 'lat' => 24.7471, 'lng' => 90.4203],
                    ['name' => 'Nandail', 'name_bn' => 'নান্দাইল', 'lat' => 24.5333, 'lng' => 90.7000],
                    ['name' => 'Phulpur', 'name_bn' => 'ফুলপুর', 'lat' => 24.9333, 'lng' => 90.4333],
                    ['name' => 'Trishal', 'name_bn' => 'ত্রিশাল', 'lat' => 24.5833, 'lng' => 90.4000],
                    ['name' => 'Tarakanda', 'name_bn' => 'তারাকান্দা', 'lat' => 24.8333, 'lng' => 90.5167],
                ],
            ],
            [
                'name' => 'Netrokona', 'name_bn' => 'নেত্রকোণা', 'lat' => 24.8703, 'lng' => 90.7279,
                'upazilas' => [
                    ['name' => 'Atpara', 'name_bn' => 'আটপাড়া', 'lat' => 24.8833, 'lng' => 90.7833],
                    ['name' => 'Barhatta', 'name_bn' => 'বারহাট্টা', 'lat' => 24.8833, 'lng' => 90.8500],
                    ['name' => 'Durgapur', 'name_bn' => 'দুর্গাপুর', 'lat' => 25.1167, 'lng' => 90.6667],
                    ['name' => 'Kalmakanda', 'name_bn' => 'কলমাকান্দা', 'lat' => 25.0833, 'lng' => 90.7667],
                    ['name' => 'Kendua', 'name_bn' => 'কেন্দুয়া', 'lat' => 24.7000, 'lng' => 90.8000],
                    ['name' => 'Khaliajuri', 'name_bn' => 'খালিয়াজুরী', 'lat' => 24.9500, 'lng' => 91.0167],
                    ['name' => 'Madan', 'name_bn' => 'মদন', 'lat' => 24.7500, 'lng' => 90.9500],
                    ['name' => 'Mohanganj', 'name_bn' => 'মোহনগঞ্জ', 'lat' => 24.8000, 'lng' => 90.8500],
                    ['name' => 'Netrokona Sadar', 'name_bn' => 'নেত্রকোণা সদর', 'lat' => 24.8703, 'lng' => 90.7279],
                    ['name' => 'Purbadhala', 'name_bn' => 'পূর্বধলা', 'lat' => 24.7667, 'lng' => 90.6833],
                ],
            ],
            [
                'name' => 'Sherpur', 'name_bn' => 'শেরপুর', 'lat' => 25.0204, 'lng' => 90.0153,
                'upazilas' => [
                    ['name' => 'Jhenaigati', 'name_bn' => 'ঝিনাইগাতী', 'lat' => 25.1500, 'lng' => 90.0000],
                    ['name' => 'Nakla', 'name_bn' => 'নকলা', 'lat' => 24.9333, 'lng' => 90.1000],
                    ['name' => 'Nalitabari', 'name_bn' => 'নালিতাবাড়ী', 'lat' => 25.1333, 'lng' => 90.1333],
                    ['name' => 'Sherpur Sadar', 'name_bn' => 'শেরপুর সদর', 'lat' => 25.0204, 'lng' => 90.0153],
                    ['name' => 'Sreebardi', 'name_bn' => 'শ্রীবরদী', 'lat' => 25.0833, 'lng' => 89.9167],
                ],
            ],

            // --- Rajshahi Division ---
            [
                'name' => 'Bogra', 'name_bn' => 'বগুড়া', 'lat' => 24.8510, 'lng' => 89.3697,
                'upazilas' => [
                    ['name' => 'Adamdighi', 'name_bn' => 'আদমদীঘি', 'lat' => 24.7833, 'lng' => 89.0500],
                    ['name' => 'Bogra Sadar', 'name_bn' => 'বগুড়া সদর', 'lat' => 24.8510, 'lng' => 89.3697],
                    ['name' => 'Dhunat', 'name_bn' => 'ধুনট', 'lat' => 24.6833, 'lng' => 89.5333],
                    ['name' => 'Dhupchanchia', 'name_bn' => 'দুপচাঁচিয়া', 'lat' => 24.9333, 'lng' => 89.1833],
                    ['name' => 'Gabtali', 'name_bn' => 'গাবতলী', 'lat' => 24.8833, 'lng' => 89.5333],
                    ['name' => 'Kahaloo', 'name_bn' => 'কাহালু', 'lat' => 24.9667, 'lng' => 89.2667],
                    ['name' => 'Nandigram', 'name_bn' => 'নন্দীগ্রাম', 'lat' => 24.8500, 'lng' => 89.2000],
                    ['name' => 'Sariakandi', 'name_bn' => 'সারিয়াকান্দি', 'lat' => 24.7833, 'lng' => 89.6500],
                    ['name' => 'Shajahanpur', 'name_bn' => 'শাজাহানপুর', 'lat' => 24.7667, 'lng' => 89.3333],
                    ['name' => 'Sherpur', 'name_bn' => 'শেরপুর', 'lat' => 24.6500, 'lng' => 89.3667],
                    ['name' => 'Shibganj', 'name_bn' => 'শিবগঞ্জ', 'lat' => 24.9167, 'lng' => 89.3833],
                    ['name' => 'Sonatala', 'name_bn' => 'সোনাতলা', 'lat' => 25.0333, 'lng' => 89.4333],
                ],
            ],
            [
                'name' => 'Chapainawabganj', 'name_bn' => 'চাঁপাইনবাবগঞ্জ', 'lat' => 24.5965, 'lng' => 88.2777,
                'upazilas' => [
                    ['name' => 'Bholahat', 'name_bn' => 'ভোলাহাট', 'lat' => 24.7167, 'lng' => 88.3333],
                    ['name' => 'Chapainawabganj Sadar', 'name_bn' => 'চাঁপাইনবাবগঞ্জ সদর', 'lat' => 24.5965, 'lng' => 88.2777],
                    ['name' => 'Gomastapur', 'name_bn' => 'গোমস্তাপুর', 'lat' => 24.7833, 'lng' => 88.2833],
                    ['name' => 'Nachole', 'name_bn' => 'নাচোল', 'lat' => 24.7500, 'lng' => 88.4667],
                    ['name' => 'Shibganj', 'name_bn' => 'শিবগঞ্জ', 'lat' => 24.7667, 'lng' => 88.1500],
                ],
            ],
            [
                'name' => 'Joypurhat', 'name_bn' => 'জয়পুরহাট', 'lat' => 25.0968, 'lng' => 89.0227,
                'upazilas' => [
                    ['name' => 'Akkelpur', 'name_bn' => 'আক্কেলপুর', 'lat' => 25.0500, 'lng' => 89.0167],
                    ['name' => 'Joypurhat Sadar', 'name_bn' => 'জয়পুরহাট সদর', 'lat' => 25.0968, 'lng' => 89.0227],
                    ['name' => 'Kalai', 'name_bn' => 'কালাই', 'lat' => 25.1333, 'lng' => 89.0667],
                    ['name' => 'Khetlal', 'name_bn' => 'ক্ষেতলাল', 'lat' => 25.1833, 'lng' => 88.9333],
                    ['name' => 'Panchbibi', 'name_bn' => 'পাঁচবিবি', 'lat' => 25.1667, 'lng' => 89.1000],
                ],
            ],
            [
                'name' => 'Naogaon', 'name_bn' => 'নওগাঁ', 'lat' => 24.7936, 'lng' => 88.9318,
                'upazilas' => [
                    ['name' => 'Atrai', 'name_bn' => 'আত্রাই', 'lat' => 24.7333, 'lng' => 89.0333],
                    ['name' => 'Badalgachhi', 'name_bn' => 'বদলগাছি', 'lat' => 24.8833, 'lng' => 88.7500],
                    ['name' => 'Dhamoirhat', 'name_bn' => 'ধামইরহাট', 'lat' => 25.0333, 'lng' => 88.7833],
                    ['name' => 'Manda', 'name_bn' => 'মান্দা', 'lat' => 24.6667, 'lng' => 88.7667],
                    ['name' => 'Mahadebpur', 'name_bn' => 'মহাদেবপুর', 'lat' => 24.7500, 'lng' => 88.6500],
                    ['name' => 'Naogaon Sadar', 'name_bn' => 'নওগাঁ সদর', 'lat' => 24.7936, 'lng' => 88.9318],
                    ['name' => 'Niamatpur', 'name_bn' => 'নিয়ামতপুর', 'lat' => 24.8000, 'lng' => 88.5500],
                    ['name' => 'Patnitala', 'name_bn' => 'পত্নীতলা', 'lat' => 25.0167, 'lng' => 88.9000],
                    ['name' => 'Porsha', 'name_bn' => 'পোরশা', 'lat' => 25.0833, 'lng' => 88.6167],
                    ['name' => 'Raninagar', 'name_bn' => 'রাণীনগর', 'lat' => 24.7333, 'lng' => 88.9333],
                    ['name' => 'Sapahar', 'name_bn' => 'সাপাহার', 'lat' => 25.0500, 'lng' => 88.5500],
                ],
            ],
            [
                'name' => 'Natore', 'name_bn' => 'নাটোর', 'lat' => 24.4206, 'lng' => 89.0000,
                'upazilas' => [
                    ['name' => 'Bagatipara', 'name_bn' => 'বাগাতিপাড়া', 'lat' => 24.4500, 'lng' => 89.0333],
                    ['name' => 'Baraigram', 'name_bn' => 'বড়াইগ্রাম', 'lat' => 24.3500, 'lng' => 89.1333],
                    ['name' => 'Gurudaspur', 'name_bn' => 'গুরুদাসপুর', 'lat' => 24.5500, 'lng' => 89.1667],
                    ['name' => 'Lalpur', 'name_bn' => 'লালপুর', 'lat' => 24.3333, 'lng' => 88.9333],
                    ['name' => 'Natore Sadar', 'name_bn' => 'নাটোর সদর', 'lat' => 24.4206, 'lng' => 89.0000],
                    ['name' => 'Singra', 'name_bn' => 'সিংড়া', 'lat' => 24.5167, 'lng' => 89.1500],
                    ['name' => 'Naldanga', 'name_bn' => 'নলডাঙ্গা', 'lat' => 24.4167, 'lng' => 88.9667],
                ],
            ],
            [
                'name' => 'Nawabganj', 'name_bn' => 'নবাবগঞ্জ', 'lat' => 24.5942, 'lng' => 88.2777,
                'upazilas' => [
                    ['name' => 'Nawabganj Sadar', 'name_bn' => 'নবাবগঞ্জ সদর', 'lat' => 24.5942, 'lng' => 88.2777],
                    ['name' => 'Shibganj', 'name_bn' => 'শিবগঞ্জ', 'lat' => 24.7500, 'lng' => 88.1667],
                ],
            ],
            [
                'name' => 'Pabna', 'name_bn' => 'পাবনা', 'lat' => 24.0064, 'lng' => 89.2372,
                'upazilas' => [
                    ['name' => 'Atgharia', 'name_bn' => 'আটঘরিয়া', 'lat' => 24.0833, 'lng' => 89.2333],
                    ['name' => 'Bera', 'name_bn' => 'বেড়া', 'lat' => 24.0833, 'lng' => 89.6000],
                    ['name' => 'Bhangura', 'name_bn' => 'ভাঙ্গুড়া', 'lat' => 24.1833, 'lng' => 89.3333],
                    ['name' => 'Chatmohar', 'name_bn' => 'চাটমোহর', 'lat' => 24.2333, 'lng' => 89.2833],
                    ['name' => 'Faridpur', 'name_bn' => 'ফরিদপুর', 'lat' => 24.2500, 'lng' => 89.3667],
                    ['name' => 'Ishwardi', 'name_bn' => 'ঈশ্বরদী', 'lat' => 24.1167, 'lng' => 89.0500],
                    ['name' => 'Pabna Sadar', 'name_bn' => 'পাবনা সদর', 'lat' => 24.0064, 'lng' => 89.2372],
                    ['name' => 'Santhia', 'name_bn' => 'সাঁথিয়া', 'lat' => 24.3833, 'lng' => 89.3000],
                    ['name' => 'Sujanagar', 'name_bn' => 'সুজানগর', 'lat' => 24.0667, 'lng' => 89.4667],
                ],
            ],
            [
                'name' => 'Rajshahi', 'name_bn' => 'রাজশাহী', 'lat' => 24.3745, 'lng' => 88.6042,
                'upazilas' => [
                    ['name' => 'Bagha', 'name_bn' => 'বাঘা', 'lat' => 24.3333, 'lng' => 88.7833],
                    ['name' => 'Bagmara', 'name_bn' => 'বাগমারা', 'lat' => 24.4167, 'lng' => 88.7833],
                    ['name' => 'Charghat', 'name_bn' => 'চারঘাট', 'lat' => 24.3500, 'lng' => 88.8667],
                    ['name' => 'Durgapur', 'name_bn' => 'দুর্গাপুর', 'lat' => 24.4833, 'lng' => 88.7167],
                    ['name' => 'Godagari', 'name_bn' => 'গোদাগাড়ী', 'lat' => 24.4500, 'lng' => 88.4333],
                    ['name' => 'Mohanpur', 'name_bn' => 'মোহনপুর', 'lat' => 24.3667, 'lng' => 88.6833],
                    ['name' => 'Paba', 'name_bn' => 'পবা', 'lat' => 24.3333, 'lng' => 88.6000],
                    ['name' => 'Puthia', 'name_bn' => 'পুঠিয়া', 'lat' => 24.3833, 'lng' => 88.8333],
                    ['name' => 'Tanore', 'name_bn' => 'তানোর', 'lat' => 24.5667, 'lng' => 88.5833],
                ],
            ],
            [
                'name' => 'Sirajganj', 'name_bn' => 'সিরাজগঞ্জ', 'lat' => 24.4534, 'lng' => 89.7006,
                'upazilas' => [
                    ['name' => 'Belkuchi', 'name_bn' => 'বেলকুচি', 'lat' => 24.3333, 'lng' => 89.6667],
                    ['name' => 'Chauhali', 'name_bn' => 'চৌহালী', 'lat' => 24.3667, 'lng' => 89.7667],
                    ['name' => 'Kamarkhanda', 'name_bn' => 'কামারখন্দ', 'lat' => 24.3500, 'lng' => 89.6833],
                    ['name' => 'Kazipur', 'name_bn' => 'কাজীপুর', 'lat' => 24.6667, 'lng' => 89.6167],
                    ['name' => 'Raiganj', 'name_bn' => 'রায়গঞ্জ', 'lat' => 24.4667, 'lng' => 89.5500],
                    ['name' => 'Shahzadpur', 'name_bn' => 'শাহজাদপুর', 'lat' => 24.1833, 'lng' => 89.5833],
                    ['name' => 'Sirajganj Sadar', 'name_bn' => 'সিরাজগঞ্জ সদর', 'lat' => 24.4534, 'lng' => 89.7006],
                    ['name' => 'Tarash', 'name_bn' => 'তাড়াশ', 'lat' => 24.5833, 'lng' => 89.5333],
                    ['name' => 'Ullahpara', 'name_bn' => 'উল্লাপাড়া', 'lat' => 24.3333, 'lng' => 89.5000],
                ],
            ],

            // --- Rangpur Division ---
            [
                'name' => 'Dinajpur', 'name_bn' => 'দিনাজপুর', 'lat' => 25.6279, 'lng' => 88.6332,
                'upazilas' => [
                    ['name' => 'Birampur', 'name_bn' => 'বীরগঞ্জ', 'lat' => 25.4167, 'lng' => 88.6167],
                    ['name' => 'Birganj', 'name_bn' => 'বিরামপুর', 'lat' => 25.5500, 'lng' => 88.4667],
                    ['name' => 'Biral', 'name_bn' => 'বিরল', 'lat' => 25.7167, 'lng' => 88.4833],
                    ['name' => 'Bochaganj', 'name_bn' => 'বোচাগঞ্জ', 'lat' => 25.7333, 'lng' => 88.3667],
                    ['name' => 'Chirirbandar', 'name_bn' => 'চিরিরবন্দর', 'lat' => 25.6333, 'lng' => 88.7833],
                    ['name' => 'Dinajpur Sadar', 'name_bn' => 'দিনাজপুর সদর', 'lat' => 25.6279, 'lng' => 88.6332],
                    ['name' => 'Fulbari', 'name_bn' => 'ফুলবাড়ী', 'lat' => 25.5333, 'lng' => 88.9167],
                    ['name' => 'Ghoraghat', 'name_bn' => 'ঘোড়াঘাট', 'lat' => 25.2833, 'lng' => 89.0000],
                    ['name' => 'Hakimpur', 'name_bn' => 'হাকিমপুর', 'lat' => 25.4167, 'lng' => 88.7500],
                    ['name' => 'Kaharole', 'name_bn' => 'কাহারোল', 'lat' => 25.7667, 'lng' => 88.6000],
                    ['name' => 'Khansama', 'name_bn' => 'খানসামা', 'lat' => 25.8167, 'lng' => 88.7500],
                    ['name' => 'Nawabganj', 'name_bn' => 'নবাবগঞ্জ', 'lat' => 25.3833, 'lng' => 88.8333],
                    ['name' => 'Parbatipur', 'name_bn' => 'পার্বতীপুর', 'lat' => 25.5833, 'lng' => 88.9000],
                ],
            ],
            [
                'name' => 'Gaibandha', 'name_bn' => 'গাইবান্ধা', 'lat' => 25.3288, 'lng' => 89.5286,
                'upazilas' => [
                    ['name' => 'Fulchhari', 'name_bn' => 'ফুলছড়ি', 'lat' => 25.1833, 'lng' => 89.6500],
                    ['name' => 'Gaibandha Sadar', 'name_bn' => 'গাইবান্ধা সদর', 'lat' => 25.3288, 'lng' => 89.5286],
                    ['name' => 'Gobindaganj', 'name_bn' => 'গোবিন্দগঞ্জ', 'lat' => 25.1833, 'lng' => 89.3667],
                    ['name' => 'Palashbari', 'name_bn' => 'পলাশবাড়ী', 'lat' => 25.2167, 'lng' => 89.5333],
                    ['name' => 'Sadullapur', 'name_bn' => 'সাদুল্লাপুর', 'lat' => 25.4167, 'lng' => 89.4167],
                    ['name' => 'Saghata', 'name_bn' => 'সাঘাটা', 'lat' => 25.2000, 'lng' => 89.7167],
                    ['name' => 'Sundarganj', 'name_bn' => 'সুন্দরগঞ্জ', 'lat' => 25.5167, 'lng' => 89.5500],
                ],
            ],
            [
                'name' => 'Kurigram', 'name_bn' => 'কুড়িগ্রাম', 'lat' => 25.8054, 'lng' => 89.6364,
                'upazilas' => [
                    ['name' => 'Bhurungamari', 'name_bn' => 'ভুরুঙ্গামারী', 'lat' => 26.0167, 'lng' => 89.6500],
                    ['name' => 'Char Rajibpur', 'name_bn' => 'চর রাজিবপুর', 'lat' => 25.8000, 'lng' => 89.7833],
                    ['name' => 'Chilmari', 'name_bn' => 'চিলমারী', 'lat' => 25.5667, 'lng' => 89.7000],
                    ['name' => 'Kurigram Sadar', 'name_bn' => 'কুড়িগ্রাম সদর', 'lat' => 25.8054, 'lng' => 89.6364],
                    ['name' => 'Nageshwari', 'name_bn' => 'নাগেশ্বরী', 'lat' => 25.9833, 'lng' => 89.6833],
                    ['name' => 'Phulbari', 'name_bn' => 'ফুলবাড়ী', 'lat' => 25.8500, 'lng' => 89.5833],
                    ['name' => 'Rajarhat', 'name_bn' => 'রাজারহাট', 'lat' => 25.7500, 'lng' => 89.5500],
                    ['name' => 'Rowmari', 'name_bn' => 'রৌমারী', 'lat' => 25.7833, 'lng' => 89.7833],
                    ['name' => 'Ulipur', 'name_bn' => 'উলিপুর', 'lat' => 25.7000, 'lng' => 89.5667],
                ],
            ],
            [
                'name' => 'Lalmonirhat', 'name_bn' => 'লালমনিরহাট', 'lat' => 25.9923, 'lng' => 89.2847,
                'upazilas' => [
                    ['name' => 'Aditmari', 'name_bn' => 'আদিতমারী', 'lat' => 25.8833, 'lng' => 89.3167],
                    ['name' => 'Hatibandha', 'name_bn' => 'হাতীবান্ধা', 'lat' => 26.1000, 'lng' => 89.1000],
                    ['name' => 'Kaliganj', 'name_bn' => 'কালীগঞ্জ', 'lat' => 25.8833, 'lng' => 89.2000],
                    ['name' => 'Lalmonirhat Sadar', 'name_bn' => 'লালমনিরহাট সদর', 'lat' => 25.9923, 'lng' => 89.2847],
                    ['name' => 'Patgram', 'name_bn' => 'পাটগ্রাম', 'lat' => 26.3333, 'lng' => 88.7500],
                ],
            ],
            [
                'name' => 'Nilphamari', 'name_bn' => 'নীলফামারী', 'lat' => 25.9316, 'lng' => 88.8560,
                'upazilas' => [
                    ['name' => 'Dimla', 'name_bn' => 'ডিমলা', 'lat' => 26.1500, 'lng' => 88.9333],
                    ['name' => 'Domar', 'name_bn' => 'ডোমার', 'lat' => 26.0667, 'lng' => 88.8167],
                    ['name' => 'Jaldhaka', 'name_bn' => 'জলঢাকা', 'lat' => 25.8667, 'lng' => 89.0000],
                    ['name' => 'Kishoreganj', 'name_bn' => 'কিশোরগঞ্জ', 'lat' => 25.7833, 'lng' => 88.7500],
                    ['name' => 'Nilphamari Sadar', 'name_bn' => 'নীলফামারী সদর', 'lat' => 25.9316, 'lng' => 88.8560],
                    ['name' => 'Saidpur', 'name_bn' => 'সৈয়দপুর', 'lat' => 25.7833, 'lng' => 88.9000],
                ],
            ],
            [
                'name' => 'Panchagarh', 'name_bn' => 'পঞ্চগড়', 'lat' => 26.3411, 'lng' => 88.5542,
                'upazilas' => [
                    ['name' => 'Atwari', 'name_bn' => 'আটোয়ারী', 'lat' => 26.2333, 'lng' => 88.4667],
                    ['name' => 'Boda', 'name_bn' => 'বোদা', 'lat' => 26.2000, 'lng' => 88.5667],
                    ['name' => 'Debiganj', 'name_bn' => 'দেবীগঞ্জ', 'lat' => 26.0833, 'lng' => 88.7333],
                    ['name' => 'Panchagarh Sadar', 'name_bn' => 'পঞ্চগড় সদর', 'lat' => 26.3411, 'lng' => 88.5542],
                    ['name' => 'Tetulia', 'name_bn' => 'তেতুলিয়া', 'lat' => 26.4833, 'lng' => 88.3500],
                ],
            ],
            [
                'name' => 'Rangpur', 'name_bn' => 'রংপুর', 'lat' => 25.7439, 'lng' => 89.2752,
                'upazilas' => [
                    ['name' => 'Badarganj', 'name_bn' => 'বদরগঞ্জ', 'lat' => 25.6667, 'lng' => 89.0333],
                    ['name' => 'Gangachara', 'name_bn' => 'গঙ্গাচড়া', 'lat' => 25.8667, 'lng' => 89.2333],
                    ['name' => 'Kaunia', 'name_bn' => 'কাউনিয়া', 'lat' => 25.6833, 'lng' => 89.3833],
                    ['name' => 'Mithapukur', 'name_bn' => 'মিঠাপুকুর', 'lat' => 25.5833, 'lng' => 89.2500],
                    ['name' => 'Pirgachha', 'name_bn' => 'পীরগাছা', 'lat' => 25.7167, 'lng' => 89.4000],
                    ['name' => 'Pirganj', 'name_bn' => 'পীরগঞ্জ', 'lat' => 25.8333, 'lng' => 89.3667],
                    ['name' => 'Rangpur Sadar', 'name_bn' => 'রংপুর সদর', 'lat' => 25.7439, 'lng' => 89.2752],
                    ['name' => 'Taraganj', 'name_bn' => 'তারাগঞ্জ', 'lat' => 25.8000, 'lng' => 89.2167],
                ],
            ],
            [
                'name' => 'Thakurgaon', 'name_bn' => 'ঠাকুরগাঁও', 'lat' => 26.0336, 'lng' => 88.4616,
                'upazilas' => [
                    ['name' => 'Baliadangi', 'name_bn' => 'বালিয়াডাঙ্গী', 'lat' => 25.8667, 'lng' => 88.3167],
                    ['name' => 'Haripur', 'name_bn' => 'হরিপুর', 'lat' => 26.1000, 'lng' => 88.5667],
                    ['name' => 'Pirganj', 'name_bn' => 'পীরগঞ্জ', 'lat' => 25.8500, 'lng' => 88.3333],
                    ['name' => 'Ranisankail', 'name_bn' => 'রাণীশংকৈল', 'lat' => 25.9167, 'lng' => 88.3333],
                    ['name' => 'Thakurgaon Sadar', 'name_bn' => 'ঠাকুরগাঁও সদর', 'lat' => 26.0336, 'lng' => 88.4616],
                ],
            ],

            // --- Sylhet Division ---
            [
                'name' => 'Habiganj', 'name_bn' => 'হবিগঞ্জ', 'lat' => 24.3745, 'lng' => 91.4155,
                'upazilas' => [
                    ['name' => 'Ajmiriganj', 'name_bn' => 'আজমিরীগঞ্জ', 'lat' => 24.4167, 'lng' => 91.3667],
                    ['name' => 'Bahubal', 'name_bn' => 'বাহুবল', 'lat' => 24.3833, 'lng' => 91.5000],
                    ['name' => 'Baniachong', 'name_bn' => 'বানিয়াচং', 'lat' => 24.5000, 'lng' => 91.3667],
                    ['name' => 'Chunarughat', 'name_bn' => 'চুনারুঘাট', 'lat' => 24.1833, 'lng' => 91.5667],
                    ['name' => 'Habiganj Sadar', 'name_bn' => 'হবিগঞ্জ সদর', 'lat' => 24.3745, 'lng' => 91.4155],
                    ['name' => 'Lakhai', 'name_bn' => 'লাখাই', 'lat' => 24.5333, 'lng' => 91.2333],
                    ['name' => 'Madhabpur', 'name_bn' => 'মাধবপুর', 'lat' => 24.2500, 'lng' => 91.6000],
                    ['name' => 'Nabiganj', 'name_bn' => 'নবীগঞ্জ', 'lat' => 24.3833, 'lng' => 91.2833],
                    ['name' => 'Shaistaganj', 'name_bn' => 'শায়েস্তাগঞ্জ', 'lat' => 24.3167, 'lng' => 91.5500],
                ],
            ],
            [
                'name' => 'Moulvibazar', 'name_bn' => 'মৌলভীবাজার', 'lat' => 24.4829, 'lng' => 91.7774,
                'upazilas' => [
                    ['name' => 'Barlekha', 'name_bn' => 'বড়লেখা', 'lat' => 24.5333, 'lng' => 91.9333],
                    ['name' => 'Juri', 'name_bn' => 'জুড়ী', 'lat' => 24.4833, 'lng' => 91.9667],
                    ['name' => 'Kamalganj', 'name_bn' => 'কমলগঞ্জ', 'lat' => 24.3500, 'lng' => 91.8500],
                    ['name' => 'Kulaura', 'name_bn' => 'কুলাউড়া', 'lat' => 24.4833, 'lng' => 91.8833],
                    ['name' => 'Moulvibazar Sadar', 'name_bn' => 'মৌলভীবাজার সদর', 'lat' => 24.4829, 'lng' => 91.7774],
                    ['name' => 'Rajnagar', 'name_bn' => 'রাজনগর', 'lat' => 24.5333, 'lng' => 91.7500],
                    ['name' => 'Sreemangal', 'name_bn' => 'শ্রীমঙ্গল', 'lat' => 24.3167, 'lng' => 91.7167],
                ],
            ],
            [
                'name' => 'Sunamganj', 'name_bn' => 'সুনামগঞ্জ', 'lat' => 25.0658, 'lng' => 91.3950,
                'upazilas' => [
                    ['name' => 'Bishwamvarpur', 'name_bn' => 'বিশ্বম্ভরপুর', 'lat' => 25.0833, 'lng' => 91.5500],
                    ['name' => 'Chhatak', 'name_bn' => 'ছাতক', 'lat' => 25.0333, 'lng' => 91.6667],
                    ['name' => 'Derai', 'name_bn' => 'দিরাই', 'lat' => 24.8167, 'lng' => 91.3833],
                    ['name' => 'Dharampasha', 'name_bn' => 'ধর্মপাশা', 'lat' => 24.9500, 'lng' => 91.3500],
                    ['name' => 'Dowarabazar', 'name_bn' => 'দোয়ারাবাজার', 'lat' => 25.0500, 'lng' => 91.7167],
                    ['name' => 'Jagannathpur', 'name_bn' => 'জগন্নাথপুর', 'lat' => 24.8333, 'lng' => 91.5500],
                    ['name' => 'Jamalganj', 'name_bn' => 'জামালগঞ্জ', 'lat' => 24.8500, 'lng' => 91.2333],
                    ['name' => 'Sulla', 'name_bn' => 'শাল্লা', 'lat' => 24.7500, 'lng' => 91.2000],
                    ['name' => 'Sunamganj Sadar', 'name_bn' => 'সুনামগঞ্জ সদর', 'lat' => 25.0658, 'lng' => 91.3950],
                    ['name' => 'Tahirpur', 'name_bn' => 'তাহিরপুর', 'lat' => 25.1500, 'lng' => 91.4500],
                    ['name' => 'Madhyanagar', 'name_bn' => 'মধ্যনগর', 'lat' => 25.0000, 'lng' => 91.4667],
                ],
            ],
            [
                'name' => 'Sylhet', 'name_bn' => 'সিলেট', 'lat' => 24.8949, 'lng' => 91.8687,
                'upazilas' => [
                    ['name' => 'Balaganj', 'name_bn' => 'বালাগঞ্জ', 'lat' => 24.7167, 'lng' => 91.7833],
                    ['name' => 'Beanibazar', 'name_bn' => 'বিয়ানীবাজার', 'lat' => 24.8167, 'lng' => 92.1667],
                    ['name' => 'Bishwanath', 'name_bn' => 'বিশ্বনাথ', 'lat' => 24.7833, 'lng' => 91.7333],
                    ['name' => 'Companiganj', 'name_bn' => 'কোম্পানীগঞ্জ', 'lat' => 25.0333, 'lng' => 91.7500],
                    ['name' => 'Fenchuganj', 'name_bn' => 'ফেঞ্চুগঞ্জ', 'lat' => 24.7167, 'lng' => 91.9333],
                    ['name' => 'Golapganj', 'name_bn' => 'গোলাপগঞ্জ', 'lat' => 24.8333, 'lng' => 92.0333],
                    ['name' => 'Gowainghat', 'name_bn' => 'গোয়াইনঘাট', 'lat' => 25.0833, 'lng' => 91.9500],
                    ['name' => 'Jaintiapur', 'name_bn' => 'জৈন্তাপুর', 'lat' => 25.1333, 'lng' => 92.1167],
                    ['name' => 'Kanaighat', 'name_bn' => 'কানাইঘাট', 'lat' => 25.0000, 'lng' => 92.2333],
                    ['name' => 'Osmani Nagar', 'name_bn' => 'ওসমানী নগর', 'lat' => 24.6667, 'lng' => 91.8833],
                    ['name' => 'South Surma', 'name_bn' => 'দক্ষিণ সুরমা', 'lat' => 24.7667, 'lng' => 91.9000],
                    ['name' => 'Sylhet Sadar', 'name_bn' => 'সিলেট সদর', 'lat' => 24.8949, 'lng' => 91.8687],
                    ['name' => 'Zakiganj', 'name_bn' => 'জকিগঞ্জ', 'lat' => 24.8667, 'lng' => 92.3000],
                ],
            ],
        ];
    }
}
