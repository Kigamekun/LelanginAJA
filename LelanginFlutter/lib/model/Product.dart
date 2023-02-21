import 'dart:developer' as developer;

class Product {
  final String id;
  final String name;
  // final String description;
  final num start_from;
  final String end_auction;
  // final int created_by;
  // final String condition;
  // final String saleroom_notice;
  // final String catalogue_note;
  final String status;
  final String thumb;

  Product(
      {required this.id,
      required this.name,
      // required this.description,
      required this.start_from,
      required this.end_auction,
      // required this.created_by,
      // required this.condition,
      // required this.saleroom_notice,
      // required this.catalogue_note,
      required this.status,
      required this.thumb});

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json["id"].toString(),
      name: json["name"],
      // description: json["description"],
      start_from: json["start_from"],
      end_auction: json["end_auction"],
      // created_by: json["created_by"],
      // condition: json["condition"],
      // saleroom_notice: json["saleroom_notice"],
      // catalogue_note: json["catalogue_note"],
      status: json["status"],
      thumb: json["thumb"],
    );
  }
}
