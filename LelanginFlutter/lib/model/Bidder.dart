import 'dart:developer' as developer;

class Bidder {
  final String id;
  final String name;
  final String auction_price;
  final bool is_you;
  final bool is_win;

  Bidder(
      {required this.id,
      required this.auction_price,
      required this.name,
      required this.is_you,
      required this.is_win});

  factory Bidder.fromJson(Map<String, dynamic> json) {
    // developer.inspect(json);
    return Bidder(
        id: json["id"].toString(),
        auction_price: json["auction_price"],
        name: json["name"],
        is_you: json["is_you"],
        is_win: json["is_win"]);
  }
}
