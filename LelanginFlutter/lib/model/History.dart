import 'dart:developer' as developer;

class History {
  final String id;
  final int auction_price;

  final String name;
  // final String description;
  final num start_from;
  final String end_auction;
  // final int created_by;
  final int product_id;
  // final String condition;
  // final String saleroom_notice;
  // final String catalogue_note;
  final String courier;
  final String airplane;
  final String no_resi;
  final String file_resi;
  final int status;
  final String thumb;

  History(
      {required this.id,
      required this.auction_price,
      required this.name,
      // required this.description,
      required this.start_from,
      required this.end_auction,
      // required this.created_by,
      required this.product_id,
      // required this.condition,
      // required this.saleroom_notice,
      // required this.catalogue_note,
      required this.courier,
      required this.airplane,
      required this.no_resi,
      required this.file_resi,
      required this.status,
      required this.thumb});

  factory History.fromJson(Map<String, dynamic> json) {
    // developer.inspect(json);
    return History(
      id: json["id"].toString(),
      auction_price: json["auction_price"],
      name: json['product']["name"],
      // description: json['product']["description"],
      start_from: json['product']["start_from"],
      end_auction: json['product']["end_auction"],
      product_id: json['product']["id"],
      // created_by: json['product']["created_by"],
      // condition: json['product']["condition"],
      courier: json["courier"],
      airplane: json["airplane"],
      no_resi: json["no_resi"],
      file_resi: json["file_resi"],
      // saleroom_notice: json['product']["saleroom_notice"],
      // catalogue_note: json['product']["catalogue_note"],
      status: json["status"],
      thumb: json['product']["thumb"],
    );
  }
}
